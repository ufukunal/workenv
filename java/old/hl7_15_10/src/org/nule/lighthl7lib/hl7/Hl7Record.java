/*
 * Hl7Record.java
 *
 * Created on March 24, 2006, 11:04 AM
 *
 * Copyright (C) 2004-2007 M Litherland
 */

package org.nule.lighthl7lib.hl7;

import java.util.*;
import java.util.regex.*;

import org.nule.lighthl7lib.util.*;

import com.sun.org.apache.xml.internal.security.utils.HelperNodeList;

/**
 * 
 * @author litherm
 * 
 * This is a utility class that can be used to manipulate or extract HL7
 * messages. No attempt has been made to make this object thread safe.
 */
public class Hl7Record
{

	private String record;
	private String[] seps;
	private List segs = null;

	/**
	 * Create a new HL7 record object from a string.
	 * 
	 * @param record
	 */
	public Hl7Record(String newRecord)
	{
		// System.out.println("recordint():"+newRecord);
		// record = newRecord.substring(1,newRecord.length()-2);
		// // seps = Hl7RecordUtil.setSeparators(record);
		// if(!record.startsWith("MSH")){
		// record = newRecord.substring(2,newRecord.length()-2);
		// }
		record = trimRecord(newRecord);
		seps = Hl7RecordUtil.setSeparators(record);
	}

	private String trimRecord(String message)
	{
	
		int k = 0;

		for (k = 0; k < message.length(); k++)
		{

			if (message.charAt(k) == 'M')
			{
				break;
			}
		}
		//System.out.println("k"+k);
//		
		String substring = message.substring(k, message.length()-2);
//		System.out.println("substring:"+substring);
		return substring;
	}

	/**
	 * Create a new HL7 record object from an array of strings listing segment
	 * headers. We don't assume to prefix the record with the MSH segment, so
	 * you should really consider including one, if you want your recort to be
	 * parsable by anything.
	 * 
	 * Note: to create a very minimal message just pass it {"MSH"}.
	 */
	public Hl7Record(String[] segHeaders)
	{
		StringBuffer sb = new StringBuffer();
		for (int i = 0; i < segHeaders.length; i++)
		{
			sb.append(segHeaders[i] + "|");
			if (i == 0)
			{
				sb.append(Hl7RecordUtil.defaultDelims);
			}
			sb.append("\r");
		}
		record = sb.toString();
		seps = Hl7RecordUtil.setSeparators(record);
	}

	/**
	 * Similar to the Hl7Record(String[]) constructor, except you specify the
	 * delimiters to use. Please understand Java escape characters before you
	 * use this (or at least test it well...)
	 * 
	 * Note: to create a very minimal message just pass it {"MSH"} and the
	 * delims of your choice.
	 */
	public Hl7Record(String[] segHeaders, String delims)
	{
		StringBuffer sb = new StringBuffer();
		for (int i = 0; i < segHeaders.length; i++)
		{
			sb.append(segHeaders[i] + delims.substring(0, 1));
			if (i == 0)
			{
				sb.append(delims.substring(1));
			}
			sb.append("\r");
		}
		record = sb.toString();
		seps = Hl7RecordUtil.setSeparators(record);
	}

	/**
	 * Returns the list of separators we have found. Only really useful for
	 * testing.
	 * 
	 * @return String[]
	 */
	public String[] getSeparators()
	{

		return seps;
	}

	/**
	 * Returns a list of segment headers based upon the current makeup of the
	 * message
	 * 
	 * @return List
	 */
	public List listSegments()
	{
		List l = new ArrayList();
		makeSegments();
		for (int i = 0; i < segs.size(); i++)
		{
			l.add(((Hl7Segment) segs.get(i)).getId());
		}
		return l;
	}

	/**
	 * Parse the segments out of the record we were created with. Each segments
	 * becomes a new Hl7Segment object.
	 */
	@SuppressWarnings("unchecked")
	private void makeSegments() throws IllegalArgumentException
	{
		if (segs != null)
		{
			return;
		}
		segs = new ArrayList();
		String[] segments = record.split(Hl7RecordUtil.sep0);
		for (int i = 0; i < segments.length; i++)
		{
			if (segments[i].length() > 2)
			{
				segs.add(new Hl7Segment(segments[i], getSeparators()));
			} else
			{
				System.out.println("too short Segemet:" + segments[i]
						+ "segemnt:");
				throw new IllegalArgumentException(
						"Too short segment received.");
			}
		}
	}

	/**
	 * Returns the number of segments
	 * 
	 * @return int
	 */
	public int size()
	{
		makeSegments();
		return segs.size();
	}

	/**
	 * Append a new segment to the end of the HL7 record.
	 */
	public void append(String segHeader)
	{
		makeSegments();
		segs.add(new Hl7Segment(segHeader + "|", seps));
		rebuild();
		// segs.get(0).toString();
	}

	/**
	 * Add a segment to the record at the specified position
	 */
	public void add(int position, String segHeader)
	{
		makeSegments();
		segs.add(position, new Hl7Segment(segHeader + "|", seps));
		rebuild();
	}

	/**
	 * Returns the first segment that matches the given segment ID. If no
	 * matching segment is found a null is returned.
	 * 
	 * @param id
	 * @return Hl7Segment.
	 */
	public Hl7Segment get(String id)
	{
		return get(id, 1);
	}

	public Hl7Segment get(String id, int count)
	{
		makeSegments();
		int found = 0;
		for (int i = 0; i < segs.size(); i++)
		{
			if (id.equals(new String(((Hl7Segment) segs.get(i)).getId())))
			{
				found++;
				if (found == count)
				{
					return (Hl7Segment) segs.get(i);
				}
			}
		}
		return null;
	}

	/**
	 * Return a segment specified by it's number. So the first segment (MSH, I
	 * hope) is segment 1, evn is probably segment 2 and so on. In other words,
	 * this is not a zero indexed array of segments, the first one is indexed 1.
	 * This is to attempt to match best the concept of counting HL7 attempts to
	 * use.
	 * 
	 * @param id
	 * @return Hl7Segment
	 */
	public Hl7Segment get(int id)
	{
		makeSegments();
		return (Hl7Segment) segs.get(id - 1);
	}

	/**
	 * Returns all available Hl7Segments as an array of that kind.
	 * 
	 * @return Hl7Segment[]
	 */
	public Hl7Segment[] getAll()
	{
		makeSegments();
		Hl7Segment[] segments = new Hl7Segment[segs.size()];
		for (int i = 0; i < segs.size(); i++)
		{
			segments[i] = (Hl7Segment) segs.get(i);
		}
		return segments;
	}

	/**
	 * Accept a string with an HL7 record somewhere in it and return only the
	 * HL7 data out of it.
	 * 
	 * @param dirty
	 * @return String
	 */
	public static String cleanString(String dirty)
	{
		if (dirty == null)
			return null;
		String record = null;
		Matcher m = Hl7RecordUtil.hl7match.matcher(dirty);
		if (m.find())
		{
			record = m.group();
		}
		return record;
	}

	/**
	 * Hand us a new string and regenerate the children.
	 * 
	 * @param newRecord
	 */
	public void changeRecord(String newRecord)
	{
		record = newRecord;
		seps = Hl7RecordUtil.setSeparators(record);
		segs = null;
	}

	/**
	 * Rebuilds the record from the segments in case they have changed.
	 * 
	 * @return Newly constructed string of record.
	 */
	public String rebuild()
	{
		// if segs is null, nothing to rebuild
		if (segs == null)
		{
			return toString();
		}
		StringBuffer newRecord = new StringBuffer();
		for (int i = 0; i < segs.size(); i++)
		{
			newRecord.append(((Hl7Segment) segs.get(i)).rebuild()
					+ Hl7RecordUtil.sep0);
		}
		changeRecord(newRecord.toString());
		return newRecord.toString();
	}

	/**
	 * Return the defined field.
	 */
	public String getField(String fieldDef)
	{
		try
		{
			return getFieldObj(fieldDef).toString();
		} catch (NullPointerException e)
		{
			return null;
		}
	}

	/**
	 * Return the defined field as an Hl7Field object.
	 */
	public Hl7Field getFieldObj(String fieldDef)
	{
		FieldMatch fm = FieldMatch.verifyFields(fieldDef);
		if (fm == null)
		{
			return null;
		}
		return fm.getFieldObj(this);
	}

	/**
	 * Set the desired field with the specified string
	 */
	public void setField(String fieldDef, String newValue)
	{
		getFieldObj(fieldDef).changeField(newValue);
	}

	/**
	 * Return the HL7 record as a string
	 */
	public String toString()
	{
		return record;
	}

	public String getAllSegmentIds()
	{
		StringBuffer buffer = new StringBuffer();
		String[] segments = record.split(Hl7RecordUtil.sep0);
		for (int i = 0; i < segments.length; i++)
		{
			buffer.append((segments[i].length() >= 3) ? segments[i].substring(
					0, 3) : "");
		}
		return buffer.toString();
	}

	public boolean validateMessageStructure(String regex)
	{
		Pattern valid = Pattern.compile(regex);
		return valid.matcher(getAllSegmentIds()).matches();
	}

	public Hl7Segment getSegment(String regex)
	{
		return getSegment(regex, 1);
	}

	public Hl7Segment getSegment(String regex, int regExMatchCount)
	{
		Pattern pattern = Pattern.compile(regex);
		Matcher matcher = pattern.matcher(getAllSegmentIds());
		// System.out.println( matcher.find());
		int count = 0;
		boolean found = true;
		while (found && count < regExMatchCount)
		{
			found = matcher.find();
			if (found)
			{
				count++;
				// System.out.println("Start:"+matcher.start());
				// System.out.println("End:"+matcher.end());
				if (count == regExMatchCount && matcher.end() % 3 == 0)
				{
					return this.get(matcher.end() / 3);
				}
			}
		}
		return null;
	}

	public String interpret(String expression)
	{
		return interpret(null, 1, expression);
	}

	public String interpret(String segmentRegEx, int regExMatchCount,
			String expression)
	{
		// EXPRESSION ::= SEGMENT '^' FIELD ['^' REFINEMENT EXPRESSION*]
		// SEGMENT ::= 'SEGMENT' '(' LITERAL ',' OCCURENCE_INDEX ')'
		// FIELD ::= 'FIELD' '(' FIELD_INDEX ',' REPEAT_INDEX ')'
		// REFINEMENT EXPRESSION ::= REFINEMENT ^ REFINEMENT
		// REFINEMENT ::= FIELD | COMPONENT | SUBCOMPONENT]
		// COMPONENT ::= 'COMPONENT' '(' COMPONENT_INDEX ')'
		// SUBCOMPONENT ::= 'SUBCOMPONENT' '(' SUBCOMPONENT_INDEX ')'
		// LITERAL ::= CHARACTERS
		// FIELD_INDEX ::= NUMBER
		// OCCURENCE_INDEX ::= NUMBER
		// COMPONENT_INDEX ::= NUMBER
		// SUBCOMPONENT_INDEX ::= NUMBER
		// REPEAT_INDEX ::= NUMBER
		//
		// EXAMPLE
		/*
		 * SEGMENT(PID,1)^FIELD(5,2)^COMPONENT(2)
		 * 
		 */
		String separator = "^";
		expression = expression.replaceAll(" ", "");
		StringTokenizer tokenizer = new StringTokenizer(expression, separator);
		Hl7Segment hl7Segment = null;
		Hl7Field hl7Field = null;

		if (segmentRegEx != null)
		{
			hl7Segment = this.getSegment(segmentRegEx, regExMatchCount);

			if (hl7Segment == null)
				return "";
		}

		int counter = 0;
		while (tokenizer.hasMoreTokens())
		{
			counter++;

			String token = tokenizer.nextToken();

			if (token.startsWith("SEGMENT"))
			{
				int startpos = token.indexOf('(');
				int endpos = token.indexOf(')');
				int commapos = token.indexOf(',');

				String segmentID = token.substring(startpos + 1, commapos);
				int segmentOccurence = Integer.parseInt(token.substring(
						commapos + 1, endpos));

				hl7Segment = this.get(segmentID, segmentOccurence);
			} else if (token.startsWith("FIELD"))
			{
				int startpos = token.indexOf('(');
				int endpos = token.indexOf(')');
				int commapos = token.indexOf(',');

				int fieldIndex = Integer.parseInt(token.substring(startpos + 1,
						commapos));
				int repeatIndex = Integer.parseInt(token.substring(
						commapos + 1, endpos));

				if (hl7Field == null)
				{
					hl7Field = hl7Segment.field(fieldIndex);
					if (hl7Field != null && repeatIndex > 1)
					{
						hl7Field = hl7Field.getRep(repeatIndex);
					}
				}
			} else if (token.startsWith("COMPONENT"))
			{
				int startpos = token.indexOf('(');
				int endpos = token.indexOf(')');

				int componentIndex = Integer.parseInt(token.substring(
						startpos + 1, endpos));

				if (hl7Field != null)
				{
					hl7Field = hl7Field.getComp(componentIndex);
				}
			} else if (token.startsWith("SUBCOMPONENT"))
			{
				int startpos = token.indexOf('(');
				int endpos = token.indexOf(')');

				int subcomponentIndex = Integer.parseInt(token.substring(
						startpos + 1, endpos));

				if (hl7Field != null)
				{
					hl7Field = hl7Field.getSubcomp(subcomponentIndex);
				}
			}

			if (hl7Segment == null)
				break;

			if (counter > 1 && hl7Field == null)
				break;
		}

		return (hl7Field != null ? hl7Field.toString() : "");

	}
}

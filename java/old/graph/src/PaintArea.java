import java.awt.Color;
import java.awt.Graphics;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;

import javax.swing.JOptionPane;
import javax.swing.JPanel;

@SuppressWarnings("serial")
public class PaintArea extends JPanel {

	final int minSpace = 15;
	int space = 10;
	int yspace = 30;
	boolean drawLine = true;
	private int dayspace = 1;

	public PaintArea() {
		super();
		String templ = "";
		try {
			BufferedReader in = new BufferedReader(new FileReader("input.txt"));
			String str;
			while ((str = in.readLine()) != null) {
				templ += str;
			}
			in.close();
		} catch (IOException e1) {
			System.err.println(e1.getMessage());
		}

		String inputs[] = templ.split(",");

		for (String string : inputs) {
			arrday.add(Integer.parseInt(string));
		}
		arr = arrday;
		// changeMode(10);
	}

	ArrayList<Integer> arrday = new ArrayList<Integer>();
	ArrayList<Integer> arr;

	public void paintComponent(Graphics g) {
		// JOptionPane.showMessageDialog(this, "here");

		super.paintComponent(g);
		int sx = 10;
		int sy = 400;
		int lastx = sx - space;
		int lasty = sy;
		int startkilo = 560;
		{
			g.setColor(Color.RED);

			int pay = ((int) arr.get(arr.size() - 1) - startkilo)
					* (yspace / 10);

			int x = lastx + space * arr.size();
			int y = sy - pay;

			g.drawLine(lastx + space,
					lasty - (602 - startkilo) * (yspace / 10), x, y);
			g.setColor(Color.BLACK);
		}
		g.drawLine(sx, sy, sx + space * 60, sy);

		// g.drawLine(sx, sy-yspace*6, sx + space * 60, sy-yspace*6);
		// g.drawLine(sx, sy-yspace*4, sx + space * 60, sy-yspace*4);

		for (int i = 0; i <= (60 / dayspace); i++) {

			// g.drawString(i + "", sx + i * space, sy);
		}

		g.drawLine(sx, sy, sx, 0);

		for (int i = 0; i <= 13; i++) {
			g.drawString((i + startkilo / 10) + "", sx, sy - i * yspace + 5);
		}

		int k = 0;

		for (int itemx : arr) {

			int item = (int) itemx;
			int pay = (item - startkilo) * (yspace / 10);

			int x = lastx + space;
			int y = sy - pay;
			if (k++ != 0) {
				g.drawLine(lastx, lasty, x, y);
			}

			lastx = x;
			lasty = y;
			if (k == arr.size()) {

			}
		}
		deviation();
	}

	private void deviation() {

		double speed = getSpeed();
		double topkare=0;
		for (int i = 0; i < arr.size(); i++) {

			double item = (double) arr.get(i);

			double ort = 602 + i * speed;

			double fark =Math.abs(item - ort) ;
			topkare+=fark;
			
		}
		
		System.out.println("varyans"+ topkare/(arr.size()-1));

	}

	private int getSpeed() {

		return (arr.get(arr.size() - 1) - 602) / arr.size();
	}

	public void payForDay(int fark) {

		int last = arr.get(arr.size() - 1);
		int first = arr.get(0);

		double oran = (double) (last - first) / arr.size();

		double result = oran * fark + last;

		JOptionPane.showMessageDialog(this, result + "");
	}

	public void changeMode(int i) {
		ArrayList<Integer> arr = new ArrayList<Integer>();
		int k = 0;
		int subtotal = 0;
		for (Integer integer : arrday) {
			k++;
			subtotal += integer;

			if (k % i == 0) {
				arr.add(subtotal / i);
				System.out.println(subtotal / i);
				subtotal = 0;

			} else if (k >= arrday.size()) {
				arr.add(subtotal / (arrday.size() % i));
				System.out.println(subtotal / (arrday.size() % i));
			}

		}
		this.arr = arr;
		this.dayspace = i;

		this.space = minSpace * dayspace;

		this.paint(this.getGraphics());
		this.doLayout();

	}
}

package test;

import static org.hamcrest.CoreMatchers.is;
import static org.junit.Assert.assertThat;

import java.awt.event.WindowEvent;
import java.util.Calendar;
import java.util.GregorianCalendar;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

import work.TimePass;
import work.WorkbookListener;
import work.xxx;

public class TimePassTest {

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
	}

	@After
	public void tearDown() throws Exception {
	}

	@Test
	public void testRefresh() throws InterruptedException {
		xxx xx = new xxx();
		xxx x = new xxx() {
			private int uu;

			{
				k = 2;
				uu = 3;
				
			}
		};
		assertThat(x.k, is(33));
		WorkbookListener listener = new WorkbookListener() {

			@Override
			public boolean exiting(WindowEvent e) {
				// TODO Auto-generated method stub
				return false;
			}
		};

	}

	/**
	 * 
	 */
	public void testGetDiff() {
		TimePass time = new TimePass();
		// String string = time.getText();
		// Thread.sleep(1000);
		// time.refresh();
		// assertThat(string, not(time.getText()));
		Calendar calendar = new GregorianCalendar(2014, 2, 25, 12, 0, 0);

		long diff = Calendar.getInstance().getTimeInMillis()
				- calendar.getTimeInMillis();
		// assertThat(time.getDiff(diff),
		// equalTo("1 day(s) 1 hour(s) 1 minute(s) 1 hours int total"));
	}
}

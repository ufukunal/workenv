package tempobet;
import org.apache.commons.codec.binary.Base64;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

public class TestTempobet {

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
	public void testTempobet() {
		Tempobet.getWeekend();
	}

	@Test
	public void testGetExternId() {
		byte[] encodedBytes = Base64
				.encodeBase64("07 Elversberg2014-04-05 15:00:00"
						.getBytes());
		System.out.println("encodedBytes " + new String(encodedBytes));
		byte[] decodedBytes = Base64.decodeBase64(encodedBytes);
		System.out.println("decodedBytes " + new String(decodedBytes));
		// Tempobet.HTMLTableParser.getExternId("blblblabla");
	}
}

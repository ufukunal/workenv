package setest;

import java.util.HashMap;
import java.util.Map;

public class Main {

	public Main() {
		// TODO Auto-generated constructor stub
	}

	public static void main(String[] args) {

		Map<String, String> map = new HashMap<String, String>();
		// Map<String, String> map = new StringMap();

		final int LOOP = 10000000;

		// run(map, LOOP);
		run(new StringMap(), LOOP);
	}

	/**
	 * @param map
	 * @param LOOP
	 */
	public static void run(Map<String, String> map, final int LOOP) {
		long start = System.currentTimeMillis();

		for (int k = 0; k < LOOP; k++) {
			map.put(k + "", "value of: " + k);
		}

		for (int k = 0; k < LOOP; k++) {
			map.get(k + "");
		}

		System.out.println("run for:" + map.getClass().getName() + " for "
				+ LOOP + " times is : "
				+ (System.currentTimeMillis() - start));
	}

}

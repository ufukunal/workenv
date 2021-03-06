package com.betfair.aping;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;

import javax.enterprise.context.SessionScoped;
import javax.faces.bean.ManagedBean;
import javax.faces.bean.ManagedProperty;
import javax.faces.event.AjaxBehaviorEvent;

import model.DualMatch;
import model.Match;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.boot.registry.StandardServiceRegistryBuilder;
import org.hibernate.cfg.Configuration;

import com.betfair.aping.util.DataTable;
import com.betfair.aping.util.Jdbc;
import com.betfair.aping.util.LevenshteinDistance;

@SessionScoped
@ManagedBean
public class Betting implements Serializable {
	// multi threading

	private static final long serialVersionUID = 1120356482214096067L;

	private DataTable matches;
	private DataTable tempoMatches;

	@ManagedProperty(value = "#{app}")
	App app;

	private List<DualMatch> dualMatchs;

	public DataTable getMatches() {
		ApiNGDemo.LOGGER.info("getting matches");
		return matches;
	}

	public void setMatches(DataTable matches) {
		this.matches = matches;
	}

	public Betting() {
		System.out.println("creating Betting");
		refresh();
	}

	public void refresh() {
		matches = Jdbc
				.select("select homeTeam,awayTeam,ht,draw,at,tarih from matchView where siteId=2 order by tarih");
		tempoMatches = Jdbc
				.select("select homeTeam,awayTeam,ht,draw,at,tarih from matchView where siteId=3 order by tarih");

		refreshDualMatchs();
		Jdbc.close("refresh");
	}

	private void refreshDualMatchs() {
		java.util.logging.Logger.getLogger("org.hibernate").setLevel(Level.OFF);
		long start = System.currentTimeMillis();
		List<Match> list = null;
		// list = Jdbc.selectMatch("select * from duplicateAll");

		Configuration configuration = new Configuration();
		Configuration cfg = configuration.configure();
		StandardServiceRegistryBuilder builder = new StandardServiceRegistryBuilder()
				.applySettings(cfg.getProperties());
		SessionFactory factory = cfg.buildSessionFactory(builder.build());

		Session ss = factory.openSession();

		try {

			ss.beginTransaction();

			list = ss.createCriteria(Match.class).list();

			ss.getTransaction().commit();
		} catch (Exception ex) {
			ex.printStackTrace();
			ss.getTransaction().rollback();
			;
		} finally {

		}

		System.out.println("mem size:" + list.size());
		System.out.println("time:" + (System.currentTimeMillis() - start));
		dualMatchs = new ArrayList<DualMatch>();
		for (final Match m : list) {
			if (m.otherId == null || m.getSite() != 2) {

				continue;
			}
			if (m.otherId != 0)
				continue;

			for (final Match ma : list) {
				if (ma.otherId == null) {
					ma.otherId = 0;
					System.out.println("nullllll" + ma.getHomeTeam());
					continue;
				}
				if (ma != m && ma.otherId == 0) {

					if (LevenshteinDistance.similarity(m.getAwayTeam(),
							ma.getAwayTeam()) > 0.5
							&& LevenshteinDistance.similarity(m.getHomeTeam(),
									ma.getHomeTeam()) > 0.5) {
						m.otherId = ma.getId();
						ma.otherId = m.getId();
						;
						DualMatch dualMatch = new DualMatch() {
							{
								homeTeam = m.getHomeTeam();
								awayTeam = ma.getAwayTeam();
								ht2 = m.getHt();
								ht3 = ma.getHt();
								at2 = m.getAt();
								at3 = ma.getAt();
								draw2 = m.getDraw();
								draw3 = ma.getDraw();
								tarih = ma.getTarih();
							}
						};

						dualMatchs.add(dualMatch);

					}
				}
			}

		}
	}

	public List<DualMatch> getDualMatchs() {
		return dualMatchs;
	}

	public void setDualMatchs(List<DualMatch> dualMatchs) {
		this.dualMatchs = dualMatchs;
	}

	public void fetchMarketBook(AjaxBehaviorEvent ajaxBehaviorEvent) {

		app.updateBetfair();
		// refresh();
	}

	public App getApp() {
		return app;
	}

	public void setApp(App app) {
		this.app = app;
	}

	public DataTable getTempoMatches() {
		return tempoMatches;
	}

	public void setTempoMatches(DataTable tempoMatches) {
		this.tempoMatches = tempoMatches;
	}
}

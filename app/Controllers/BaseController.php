<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		$this->db = \Config\Database::connect();
	}

	protected function getCompetitions($id, $level) {
		return $this->db->query(sprintf(<<<QUERY
			select c.ID as ID, Level, Year, c.Name as Name, p.ID as ProvinceID, p.Name as HostName, HostCountryCode, HostCountryName, City, DateBegin, DateEnd, Contestants, Provinces, ScorePr, Started, Finished, DataComplete, Note from Competition c
			left join Province p on p.ID = c.Host
			left join (
				select Competition, count(Person) as Contestants, count(distinct(Province)) as Provinces from Contestant
				group by Competition
			) as contestants on c.ID = contestants.Competition
			where 1
			%s
			%s
			order by Year desc
		QUERY, $id ? 'and c.ID = ?' : '', $level ? 'and c.Level = ?' : ''), array_values(array_filter([$id, $level])))->getResultArray();
	}

	protected function getCompetitionMedals($level) {
		return $this->db->query(<<<QUERY
			select c.ID, Medal, Cnt
			from Competition c
			left join (
				select Competition, 
				case
					when Medal = 'G' then 'Golds'
					when Medal = 'S' then 'Silvers'
					when Medal = 'B' then 'Bronzes'
					else 'Participants'
				end as Medal, count(*) as Cnt
				from Contestant
				where TeamNo = 1
				group by Competition, Medal
			) as contestants on c.ID = contestants.Competition
			where Level = ?
			order by Year desc
		QUERY, [$level])->getResultArray();
	}

	protected function getCompetitionCommittee($id) {
		return $this->db->query(<<<QUERY
			select c.Person as PersonID, p.Name as PersonName, Role, Chair
			from Committee c
			join Person p on p.ID = c.Person
			where Competition = ?
			order by Chair desc, p.Name asc
		QUERY, [$id])->getResultArray();
	}

	protected function getNationalMedals() {
		return $this->db->query(<<<QUERY
			select c.Level as Level, Golds, Silvers, Bronzes, Participants from (
				select distinct(Level) as Level from Competition
				where Level <> 'National'
			) as c
			left join (
				select comp.Level as Level, count(Medal) as Golds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where Medal = 'G'
				and TeamNo = 1
				group by comp.Level
			) as golds on c.Level = golds.Level
			left join (
				select comp.Level as Level, count(Medal) as Silvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where Medal = 'S'
				and TeamNo = 1
				group by comp.Level
			) as silvers on c.Level = silvers.Level
			left join (
				select comp.Level as Level, count(Medal) as Bronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where Medal = 'B'
				and TeamNo = 1
				group by comp.Level
			) as bronzes on c.Level = bronzes.Level
			left join (
				select comp.Level as Level, count(Medal) as Participants
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where Medal = ''
				and TeamNo = 1
				group by comp.Level
			) as participants on c.Level = participants.Level
			order by Level asc
		QUERY)->getResultArray();
	}

	protected function getProvinceMedals($id, $competitionId) {
		return $this->db->query(sprintf(<<<QUERY
			select p.ID as ID, pr.Name as Name, Golds, Silvers, Bronzes, Participants,
			rank() over (order by %3\$s) as `Rank`
			from (
				select distinct(Province) as ID from Contestant where 1 %1\$s
			) as p
			join Province pr on p.ID = pr.ID
			left join (
				select Province as ID, count(Medal) as Golds
				from Contestant
				where Medal = 'G' %1\$s
				group by Province
			) as golds on p.ID = golds.ID
			left join (
				select Province as ID, count(Medal) as Silvers
				from Contestant
				where Medal = 'S' %1\$s
				group by Province
			) as silvers on p.ID = silvers.ID
			left join (
				select Province as ID, count(Medal) as Bronzes
				from Contestant
				where Medal = 'B' %1\$s
				group by Province
			) as bronzes on p.ID = bronzes.ID
			left join (
				select Province as ID, count(Medal) as Participants
				from Contestant
				where Medal = '' %1\$s
				group by Province
			) as participants on p.ID = participants.ID
			where 1 %2\$s
			order by %3\$s, coalesce(Participants, 0) desc, Name asc
		QUERY, $competitionId ? 'and Competition = ?' : '', $id ? 'and p.ID = ?' : '', 'coalesce(Golds, 0) desc, coalesce(Silvers, 0) desc, coalesce(Bronzes, 0) desc'),
		array_values(array_filter([$competitionId, $competitionId, $competitionId, $competitionId, $competitionId, $id])))->getResultArray();
	}

	protected function getPersonMedals($id, $name) {
		return $this->getMedals('Person', $id, $name);
	}

	protected function getSchoolMedals($id, $name) {
		return $this->getMedals('School', $id, $name);
	}

	protected function getMedals($type, $id, $name) {
		return $this->db->query(sprintf(<<<QUERY
			select *
			from (
				select c.ID as ID, Name, rank() over (order by %2\$s) as `Rank`,
				InternationalGolds, InternationalSilvers, InternationalBronzes, InternationalParticipants,
				RegionalGolds, RegionalSilvers, RegionalBronzes, RegionalParticipants,
				NationalGolds, NationalSilvers, NationalBronzes, NationalParticipants
				from (
					select ID, Name from %1\$s %3\$s
				) as c
				left join (
					select %1\$s, count(Medal) as InternationalGolds
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'International' and Medal = 'G'
					group by %1\$s
				) as iGolds on c.ID = iGolds.%1\$s
				left join (
					select %1\$s, count(Medal) as InternationalSilvers
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'International' and Medal = 'S'
					group by %1\$s
				) as iSilvers on c.ID = iSilvers.%1\$s
				left join (
					select %1\$s, count(Medal) as InternationalBronzes
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'International' and Medal = 'B'
					group by %1\$s
				) as iBronzes on c.ID = iBronzes.%1\$s
				left join (
					select %1\$s, count(Medal) as InternationalParticipants
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'International' and Medal = ''
					group by %1\$s
				) as iParticipants on c.ID = iParticipants.%1\$s
				left join (
					select %1\$s, count(Medal) as RegionalGolds
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'Regional' and Medal = 'G'
					group by %1\$s
				) as rGolds on c.ID = rGolds.%1\$s
				left join (
					select %1\$s, count(Medal) as RegionalSilvers
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'Regional' and Medal = 'S'
					group by %1\$s
				) as rSilvers on c.ID = rSilvers.%1\$s
				left join (
					select %1\$s, count(Medal) as RegionalBronzes
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'Regional' and Medal = 'B'
					group by %1\$s
				) as rBronzes on c.ID = rBronzes.%1\$s
				left join (
					select %1\$s, count(Medal) as RegionalParticipants
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'Regional' and Medal = ''
					group by %1\$s
				) as rParticipants on c.ID = rParticipants.%1\$s
				left join (
					select %1\$s, count(Medal) as NationalGolds
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'National' and Medal = 'G'
					group by %1\$s
				) as nGolds on c.ID = nGolds.%1\$s
				left join (
					select %1\$s, count(Medal) as NationalSilvers
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'National' and Medal = 'S'
					group by %1\$s
				) as nSilvers on c.ID = nSilvers.%1\$s
				left join (
					select %1\$s, count(Medal) as NationalBronzes
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'National' and Medal = 'B'
					group by %1\$s
				) as nBronzes on c.ID = nBronzes.%1\$s
				left join (
					select %1\$s, count(Medal) as NationalParticipants
					from Contestant c
					join Competition comp on comp.ID = c.Competition
					where comp.Level = 'National' and Medal = ''
					group by %1\$s
				) as nParticipants on c.ID = nParticipants.%1\$s
				order by %2\$s, coalesce(InternationalParticipants, 0) desc, coalesce(RegionalParticipants, 0) desc, coalesce(NationalParticipants, 0) desc, Name asc
			) x
			where %4\$s
		QUERY, $type, <<<WINDOW
			coalesce(InternationalGolds, 0) desc, coalesce(InternationalSilvers, 0) desc, coalesce(InternationalBronzes, 0) desc,
			coalesce(RegionalGolds, 0) desc, coalesce(RegionalSilvers, 0) desc, coalesce(RegionalBronzes, 0) desc,
			coalesce(NationalGolds, 0) desc, coalesce(NationalSilvers, 0) desc, coalesce(NationalBronzes, 0) desc
		WINDOW, $id ? 'where ID = ?' : '', $name ? "name like '%$name%' limit 100" : '`Rank` <= 100'), [$id])->getResultArray();
	}
}

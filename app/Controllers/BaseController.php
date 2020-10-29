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
			select c.ID as ID, Level, Year, c.Name as Name, p.ID as ProvinceID, p.Name as HostName, Website, City, DateBegin, DateEnd, Contestants, Provinces, ScorePr from Competition c
			left join Province p on p.ID = c.Host
			left join (
				select Competition, count(Person) as Contestants, count(distinct(Province)) as Provinces from Contestant
				group by Competition
			) as contestants on c.ID = contestants.Competition
			where 1
			%s
			%s
			order by Year desc
		QUERY, $id ? 'and c.ID = ?' : '', $level ? 'and c.Level = ?' : ''), array_values(array_filter([$id, $level], 'strlen')))->getResultArray();
	}

	protected function getProvinceMedals($id, $competitionId) {
		return $this->db->query(sprintf(<<<QUERY
			select p.ID as ID, pr.Name as Name, Golds, Silvers, Bronzes, Participants from (
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
			order by coalesce(Golds, 0) desc, coalesce(Silvers, 0) desc, coalesce(Bronzes, 0) desc, coalesce(Participants, 0), Name asc
		QUERY, $competitionId ? 'and Competition = ?' : '', $id ? 'and p.ID = ?' : ''),
		array_values(array_filter([$competitionId, $competitionId, $competitionId, $competitionId, $competitionId, $id], 'strlen')))->getResultArray();
	}

	protected function getPersonMedals($id) {
		return $this->db->query(sprintf(<<<QUERY
			select c.ID as ID, Name,
			InternationalGolds, InternationalSilvers, InternationalBronzes, InternationalParticipants,
			RegionalGolds, RegionalSilvers, RegionalBronzes, RegionalParticipants,
			NationalGolds, NationalSilvers, NationalBronzes, NationalParticipants
			from (
				select ID, Name from Person %s
			) as c
			left join (
				select Person, count(Medal) as InternationalGolds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = 'G'
				group by Person
			) as iGolds on c.ID = iGolds.Person
			left join (
				select Person, count(Medal) as InternationalSilvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = 'S'
				group by Person
			) as iSilvers on c.ID = iSilvers.Person
			left join (
				select Person, count(Medal) as InternationalBronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = 'B'
				group by Person
			) as iBronzes on c.ID = iBronzes.Person
			left join (
				select Person, count(Medal) as InternationalParticipants
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'International' and Medal = ''
				group by Person
			) as iParticipants on c.ID = iParticipants.Person
			left join (
				select Person, count(Medal) as RegionalGolds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = 'G'
				group by Person
			) as rGolds on c.ID = rGolds.Person
			left join (
				select Person, count(Medal) as RegionalSilvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = 'S'
				group by Person
			) as rSilvers on c.ID = rSilvers.Person
			left join (
				select Person, count(Medal) as RegionalBronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = 'B'
				group by Person
			) as rBronzes on c.ID = rBronzes.Person
			left join (
				select Person, count(Medal) as RegionalParticipants
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'Regional' and Medal = ''
				group by Person
			) as rParticipants on c.ID = rParticipants.Person
			left join (
				select Person, count(Medal) as NationalGolds
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = 'G'
				group by Person
			) as nGolds on c.ID = nGolds.Person
			left join (
				select Person, count(Medal) as NationalSilvers
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = 'S'
				group by Person
			) as nSilvers on c.ID = nSilvers.Person
			left join (
				select Person, count(Medal) as NationalBronzes
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = 'B'
				group by Person
			) as nBronzes on c.ID = nBronzes.Person
			left join (
				select Person, count(Medal) as NationalParticipants
				from Contestant c
				join Competition comp on comp.ID = c.Competition
				where comp.Level = 'National' and Medal = ''
				group by Person
			) as nParticipants on c.ID = nParticipants.Person
			order by coalesce(InternationalGolds, 0) desc, coalesce(InternationalSilvers, 0) desc, coalesce(InternationalBronzes, 0) desc, coalesce(InternationalParticipants, 0) desc,
			coalesce(RegionalGolds, 0) desc, coalesce(RegionalSilvers, 0) desc, coalesce(RegionalBronzes, 0) desc, coalesce(RegionalParticipants, 0) desc,
			coalesce(NationalGolds, 0) desc, coalesce(NationalSilvers, 0) desc, coalesce(NationalBronzes, 0) desc, coalesce(NationalParticipants, 0) desc, Name asc
			limit 100
		QUERY, $id ? 'where ID = ?' : ''), [$id])->getResultArray();
	}
}

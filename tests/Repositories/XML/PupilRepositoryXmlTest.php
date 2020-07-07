<?php

use Mockery as m;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\PupilNotFound;

class PupilRepositoryXmlTest extends BaseTest
{
    public function getRepository()
    {
        $manager = new \SimonBowen\IsamsDrivers\XML\Manager(file_get_contents('./tests/data.xml'));

        $loader = m::mock(SimonBowen\IsamsDrivers\XML\Loader::class);
        $loader->shouldReceive('get')
            ->andReturn($manager);

        $entity = new \SimonBowen\IsamsDrivers\Entities\Pupil();
        $hydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator($entity);
        $pupilRepository = new \SimonBowen\IsamsDrivers\Repositories\XML\PupilRepository($loader, $hydrator);

        return $pupilRepository;
    }

    public function test_get_all_pupils()
    {
        $repository = $this->getRepository();

        $members = $repository->all();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $members);

        /** @var \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil $first */
        $first = $members->first();
        $this->assertEquals($first->getId(), 1);
        $this->assertEquals($first->getName(), 'Simon Bowen');
        $this->assertEquals($first->getEmail(), '9bowens@isams.org');
        $this->assertEquals($first->getSchoolCode(), '17994');
        $this->assertEquals($first->getSchoolId(), '1630785976');
        $this->assertEquals($first->getUserCode(), '9BOWENS001');
        $this->assertEquals($first->getUserName(), '9bowens');
        $this->assertEquals($first->getTitle(), 'Mr');
        $this->assertEquals($first->getForename(), 'Simon');
        $this->assertEquals($first->getSurname(), 'Bowen');
        $this->assertEquals($first->getMiddlename(), 'Edward');
        $this->assertEquals($first->getInitials(), 'SEB');
        $this->assertEquals($first->getPreferredName(), 'Simon');
        $this->assertEquals($first->getFullname(), 'Simon Bowen');
        $this->assertEquals($first->getGender(), 'M');
        $this->assertEquals($first->getDOB(), '1998-01-15T00:00:00');
        $this->assertEquals($first->getBoardingHouse(), 'Green');
        $this->assertEquals($first->getPupilType(), 'Boarder');
        $this->assertEquals($first->getEnrolmentDate(), '2009-09-07T00:00:00');
        $this->assertEquals($first->getEnrolmentTerm(), 'EnrolmentTerm');
        $this->assertEquals($first->getEnrolmentSchoolYear(), '2009');

        /* @var \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil $first */
        $last = $members->last();
        $this->assertEquals($last->getId(), 2);
        $this->assertEquals($last->getName(), 'Reginald Kray');
        $this->assertEquals($last->getEmail(), '9krayr@isams.org');
        $this->assertEquals($last->getSchoolCode(), '18031');
        $this->assertEquals($last->getSchoolId(), '1630688728');
        $this->assertEquals($last->getUserCode(), 'ReginaldKray103117279191232');
        $this->assertEquals($last->getUserName(), '9krayr');
        $this->assertEquals($last->getTitle(), 'Mr');
        $this->assertEquals($last->getForename(), 'Reginald');
        $this->assertEquals($last->getSurname(), 'Kray');
        $this->assertEquals($last->getMiddlename(), '');
        $this->assertEquals($last->getInitials(), 'RK');
        $this->assertEquals($last->getPreferredName(), 'Reg');
        $this->assertEquals($last->getFullname(), 'Reginald Kray');
        $this->assertEquals($last->getGender(), 'M');
        $this->assertEquals($last->getDOB(), '1999-01-01T00:00:00');
        $this->assertEquals($last->getBoardingHouse(), 'Blue');
        $this->assertEquals($last->getPupilType(), 'Day Boarder');
        $this->assertEquals($last->getEnrolmentDate(), '2015-09-07T00:00:00');
        $this->assertEquals($last->getEnrolmentTerm(), 'EnrolmentTerm');
        $this->assertEquals($last->getEnrolmentSchoolYear(), '2009');
    }

    public function test_get_pupil_by_id()
    {
        $repository = $this->getRepository();
        $pupil = $repository->getById(1);

        $this->assertEquals($pupil->getId(), 1);
        $this->assertEquals($pupil->getName(), 'Simon Bowen');
        $this->assertEquals($pupil->getEmail(), '9bowens@isams.org');
        $this->assertEquals($pupil->getSchoolCode(), '17994');
        $this->assertEquals($pupil->getSchoolId(), '1630785976');
        $this->assertEquals($pupil->getUserCode(), '9BOWENS001');
        $this->assertEquals($pupil->getUserName(), '9bowens');
        $this->assertEquals($pupil->getTitle(), 'Mr');
        $this->assertEquals($pupil->getForename(), 'Simon');
        $this->assertEquals($pupil->getSurname(), 'Bowen');
        $this->assertEquals($pupil->getMiddlename(), 'Edward');
        $this->assertEquals($pupil->getInitials(), 'SEB');
        $this->assertEquals($pupil->getPreferredName(), 'Simon');
        $this->assertEquals($pupil->getFullname(), 'Simon Bowen');
        $this->assertEquals($pupil->getGender(), 'M');
        $this->assertEquals($pupil->getDOB(), '1998-01-15T00:00:00');
        $this->assertEquals($pupil->getBoardingHouse(), 'Green');
        $this->assertEquals($pupil->getPupilType(), 'Boarder');
        $this->assertEquals($pupil->getEnrolmentDate(), '2009-09-07T00:00:00');
        $this->assertEquals($pupil->getEnrolmentTerm(), 'EnrolmentTerm');
        $this->assertEquals($pupil->getEnrolmentSchoolYear(), '2009');
    }

    public function test_get_pupil_by_email()
    {
        $repository = $this->getRepository();
        $pupil = $repository->getByEmail('9krayr@isams.org');

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil', $pupil);
        $this->assertEquals($pupil->getId(), 2);
        $this->assertEquals($pupil->getName(), 'Reginald Kray');
        $this->assertEquals($pupil->getEmail(), '9krayr@isams.org');
        $this->assertEquals($pupil->getSchoolCode(), '18031');
        $this->assertEquals($pupil->getSchoolId(), '1630688728');
        $this->assertEquals($pupil->getUserCode(), 'ReginaldKray103117279191232');
        $this->assertEquals($pupil->getUserName(), '9krayr');
        $this->assertEquals($pupil->getTitle(), 'Mr');
        $this->assertEquals($pupil->getForename(), 'Reginald');
        $this->assertEquals($pupil->getSurname(), 'Kray');
        $this->assertEquals($pupil->getMiddlename(), '');
        $this->assertEquals($pupil->getInitials(), 'RK');
        $this->assertEquals($pupil->getPreferredName(), 'Reg');
        $this->assertEquals($pupil->getFullname(), 'Reginald Kray');
        $this->assertEquals($pupil->getGender(), 'M');
        $this->assertEquals($pupil->getDOB(), '1999-01-01T00:00:00');
        $this->assertEquals($pupil->getBoardingHouse(), 'Blue');
        $this->assertEquals($pupil->getPupilType(), 'Day Boarder');
        $this->assertEquals($pupil->getEnrolmentDate(), '2015-09-07T00:00:00');
        $this->assertEquals($pupil->getEnrolmentTerm(), 'EnrolmentTerm');
        $this->assertEquals($pupil->getEnrolmentSchoolYear(), '2009');
    }

    public function test_get_pupil_by_email_caseinsensitive()
    {
        $repository = $this->getRepository();
        $pupil = $repository->getByEmail('9Krayr@isams.org');

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil', $pupil);
        $this->assertEquals($pupil->getId(), 2);
        $this->assertEquals($pupil->getName(), 'Reginald Kray');
        $this->assertEquals($pupil->getEmail(), '9krayr@isams.org');
        $this->assertEquals($pupil->getSchoolCode(), '18031');
        $this->assertEquals($pupil->getSchoolId(), '1630688728');
        $this->assertEquals($pupil->getUserCode(), 'ReginaldKray103117279191232');
        $this->assertEquals($pupil->getUserName(), '9krayr');
        $this->assertEquals($pupil->getTitle(), 'Mr');
        $this->assertEquals($pupil->getForename(), 'Reginald');
        $this->assertEquals($pupil->getSurname(), 'Kray');
        $this->assertEquals($pupil->getMiddlename(), '');
        $this->assertEquals($pupil->getInitials(), 'RK');
        $this->assertEquals($pupil->getPreferredName(), 'Reg');
        $this->assertEquals($pupil->getFullname(), 'Reginald Kray');
        $this->assertEquals($pupil->getGender(), 'M');
        $this->assertEquals($pupil->getDOB(), '1999-01-01T00:00:00');
        $this->assertEquals($pupil->getBoardingHouse(), 'Blue');
        $this->assertEquals($pupil->getPupilType(), 'Day Boarder');
        $this->assertEquals($pupil->getEnrolmentDate(), '2015-09-07T00:00:00');
        $this->assertEquals($pupil->getEnrolmentTerm(), 'EnrolmentTerm');
        $this->assertEquals($pupil->getEnrolmentSchoolYear(), '2009');
    }

    public function test_get_pupils_by_boarding_house()
    {
        $repository = $this->getRepository();
        $pupils = $repository->getByBoardingHouse('Blue');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $pupils);
        $this->assertEquals(1, count($pupils));

        $pupil = $pupils[0];

        $this->assertEquals($pupil->getId(), 2);
        $this->assertEquals($pupil->getName(), 'Reginald Kray');
        $this->assertEquals($pupil->getEmail(), '9krayr@isams.org');
        $this->assertEquals($pupil->getSchoolCode(), '18031');
        $this->assertEquals($pupil->getSchoolId(), '1630688728');
        $this->assertEquals($pupil->getUserCode(), 'ReginaldKray103117279191232');
        $this->assertEquals($pupil->getUserName(), '9krayr');
        $this->assertEquals($pupil->getTitle(), 'Mr');
        $this->assertEquals($pupil->getForename(), 'Reginald');
        $this->assertEquals($pupil->getSurname(), 'Kray');
        $this->assertEquals($pupil->getMiddlename(), '');
        $this->assertEquals($pupil->getInitials(), 'RK');
        $this->assertEquals($pupil->getPreferredName(), 'Reg');
        $this->assertEquals($pupil->getFullname(), 'Reginald Kray');
        $this->assertEquals($pupil->getGender(), 'M');
        $this->assertEquals($pupil->getDOB(), '1999-01-01T00:00:00');
        $this->assertEquals($pupil->getBoardingHouse(), 'Blue');
        $this->assertEquals($pupil->getPupilType(), 'Day Boarder');
        $this->assertEquals($pupil->getEnrolmentDate(), '2015-09-07T00:00:00');
        $this->assertEquals($pupil->getEnrolmentTerm(), 'EnrolmentTerm');
        $this->assertEquals($pupil->getEnrolmentSchoolYear(), '2009');
    }

    /**
     * @throws PupilNotFound
     */
    public function test_throws_pupil_not_found_exception_by_id()
    {
        $this->expectException(PupilNotFound::class);
        $repository = $this->getRepository();
        $pupil = $repository->getById(1000000000000);
    }

    /**
     * @throws PupilNotFound
     */
    public function test_throws_pupil_not_found_exception_by_email()
    {
        $this->expectException(PupilNotFound::class);
        $repository = $this->getRepository();
        $pupil = $repository->getByEmail('steve.jobs@apple.com');
    }
}

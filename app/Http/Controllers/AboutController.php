<?php

use GSVnet\Committees\CommitteesRepository;
use GSVnet\Senates\SenatesRepository;

class AboutController extends BaseController
{
    public function __construct(CommitteesRepository $committees, SenatesRepository $senates)
    {
        $this->committees = $committees;
        $this->senates = $senates;
    }

    public function showAbout()
    {
        $key = Config::get('google.key');
        $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center=Hereweg%2040,Groningen,Nederland&size=480x320&zoom=14&sensor=false&markers=color:purple%7Clabel:S%7CHereweg%2040,Groningen,Nederland&key=".$key."&scale=2";
        $mapImage = base64_encode(file_get_contents($mapUrl));
        
        return view('de-gsv.de-gsv', compact('mapImage'));
    }

    public function showCommittees(CommitteesRepository $committeesRepo)
    {
        $committees = $committeesRepo->all();

        return view('de-gsv.committees.index')
            ->with('committees', $committees);
    }

    public function showCommittee($slug, CommitteesRepository $committeesRepo)
    {
        $committee = $committeesRepo->bySlug($slug);
        $committees = $committeesRepo->all();
        $activeMembers = $committee->activeMembers;

        return view('de-gsv.committees.show')
            ->with('committee', $committee)
            ->with('committees', $committees)
            ->with('activeMembers', $activeMembers);
    }

    public function showSenates(SenatesRepository $senatesRepository)
    {
        $senates = $senatesRepository->all();

        return view('de-gsv.senates.index')
            ->with('senates', $senates);
    }

    public function showSenate($id, SenatesRepository $senatesRepository)
    {
        $senate = $senatesRepository->byId($id);
        $members = $senate->members()->get();
        $senates = $senatesRepository->all();

        return view('de-gsv.senates.single')
            ->with('currentSenate', $senate)
            ->with('members', $members)
            ->with('senates', $senates);
    }

    public function showFormerMembers()
    {
        return view('de-gsv.former-members');
    }

    public function showConfidants()
    {
        return view('de-gsv.confidants');
    }

    public function showContact()
    {
        return view('de-gsv.contact');
    }

    public function showPillars()
    {
        return view('de-gsv.pillars');
    }

    public function showHistory()
    {
        return view('de-gsv.history');
    }
}

@extends('layouts.default')

@section('title', $committee->name . ' - Commissies van de GSV')
@section('description', $committee->description)
@section('body-id', 'committee-page')

@section('content')

    <div class="column-holder" role="main">
        <h1>{{{ $committee->name }}}</h1>

        <div class="main-content">
            <p>
                {{{ $committee->description }}}
            </p>

            @can('users.show')
                @if( $activeMembers->count() > 0 )
                    <h2>Leden</h2>

                    <ul class="unstyled-list title-description-list">
                        @foreach ($activeMembers as $member)
                            <li>
                                @can('users.show')
                                    <a href="{{ URL::action('UserController@showUser', [$member->id]) }}" title="Bekijk het profiel van {{{ $member->fullName }}}" class="list-title">{{{ $member->present()->fullName }}}</a>
                                @else
                                    <span class="list-title">{{{ $member->present()->fullName }}}</span>
                                @endcan

                                <span class="list-description grey">Sinds {{ $member->present()->inCommiteeSince }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endcan
        </div>

        <div id="committees" class="secondary-column">
            <div class="form-group">
                <label class="control-label" for="inputSearch">Zoeken</label>
                <input type="text" class="search form-control" id="inputSearch" name="inputSearch" placeholder="Zoeken">
            </div>
            <ul class="list secondary-menu">
                @foreach ($committees as $committee)
                    <li><a class="committee" href="{{ URL::action('AboutController@showCommittee', $committee->unique_name) }}">{{ $committee->name }}</a> <span class="hide slug">({{{$committee->unique_name}}})</span></li>
                @endforeach
            </ul>
        </div>

    </div>
@stop
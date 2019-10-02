@extends('layouts.app')

@section('content')


<!-- Page Content -->
<div class="content">
    <div class="row">

        <div class="col-md-6">
            <!-- Block Tabs With Options Default Style -->
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header block-header-default bg-gd-aqua">
                    <h3 class="block-title">{{ __('common.Studies') }} </h3>

                </div>
                <form action="{{ action('StudyPersonController@index') }}" method="POST">
                    <input name="_method" type="hidden" value="GET">
                    @csrf
                    <div class="block-content pb-4">
                        <select class="form-control form-control" id="sid" name="sid" title="{{ __('common.Study') }}"
                            onchange="this.form.submit()">
                            <option value="">{{ __('common.Select') }}</option>
                            @if(@$studies)
                            @if(@$studies->count())
                            @foreach($studies as $study)
                            <option value="{{ $study->id }}" @if(@$sid==$study->id) selected @endif>{{ $study->name }}
                            </option>
                            @endforeach
                            @endif
                            @endif

                        </select>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">

                                <a class="btn btn-warning btn-block" href="{{ action('StudyPersonController@index' )}}">
                                    <i class="si si-action-undo mr-1"></i>
                                    {{ __('common.Reset') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Block Tabs With Options Default Style -->
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header block-header-default bg-gd-aqua">
                    <h3 class="block-title">{{ __('common.Persons') }} </h3>

                </div>
                @if(@$sid)
                <form action="{{ action('StudyPersonController@attach', $sid) }}" method="POST">
                    <input name="_method" type="hidden" value="GET">
                    <input type="hidden" name="sid" value="{{@$sid}}">
                    @csrf
                    @endif
                    <div class="block-content pb-4">
                        <select class="form-control form-control" id="pid" name="pid" title="{{ __('common.Person') }}"
                            @if(@$sid) @else disabled @endif>
                            <option value="">{{ __('common.Select') }}</option>
                            @if(@$sid && @$persons)
                            @foreach($persons as $person)
                            <option value="{{ $person->id }}" {{ (@$pid == $person->id ? 'selected':'') }}>
                                {{ $person->last_name }} {{ $person->first_name }} </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block"
                                    {{ (old('sid') || @$sid ? '':'disabled') }}>
                                    <i class="si si-fire mr-1"></i>
                                    {{ __('common.Add') }}

                                </button>
                            </div>
                        </div>
                    </div>
                    @if(@$sid)
                </form>
                @endif
            </div>


        </div>


    </div>

    @if (@$study_persons && $current_study)
    @if(@$study_persons->count() > 0)
    <div class="row">
        <div class="col-md-12">
            <!-- Table Sections (.js-table-sections class is initialized in Helpers.tableToolsSections()) -->

            <div class="block block-rounded block-themed block-fx-pop animated fadeIn">

                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('common.Persons') }}
                        @if ($current_study)
                        {{__('common.In')}} {{ @$current_study->name }}
                        @endif
                    </h3>
                </div>

                <div class="block-content">

                    <table class="js-table-sections table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th style="width: 30px; border-top: none;"></th>
                                <th style="border-top: none;">
                                    @sortablelink('last_name', __('common.LastName'))
                                </th>
                                <th style="border-top: none;">
                                    @sortablelink('first_name', __('common.FirstName'))
                                </th>
                                <th style="border-top: none;" class="text-right">

                                </th>
                            </tr>
                        </thead>
                        @csrf
                        @foreach($study_persons as $person)
                        <tbody class="js-table-sections-header">
                            <tr>
                                <td class="text-center">
                                    <i class="fa fa-angle-right text-muted"></i>
                                </td>
                                <td>
                                    <div class="py-1">
                                        <a href="#">{{ $person->last_name }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="py-1">
                                        <a href="#">{{ $person->first_name }}</a>
                                    </div>
                                </td>

                                <td class="d-none d-sm-table-cell text-right">
                                    @can('update studies')
                                    @if ($person->id)
                                    <form action="{{ action('StudyPersonController@detach', [$sid, $person->id]) }}"
                                        method="POST">
                                        <input name="_method" type="hidden" value="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            title="{{__('common.Delete')}}">
                                            <i class="nav-main-link-icon si si-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan

                                </td>
                            </tr>
                        </tbody>
                        <tbody class="font-size-sm">
                            <tr>
                                <td class="text-center"></td>
                                <td colspan="10">
                                    <p>
                                        <em
                                            class="text-muted">{{ Carbon::parse($person->updated_at)->format('d.m.Y H:i')}}</em>
                                    </p>
                                </td>

                            </tr>

                        </tbody>
                        @endforeach
                    </table>

                </div>


            </div>
        </div>
    </div>
    @endif
    @endif
    <!-- END Table Sections -->
</div>
<!-- END Page Content -->


@endsection
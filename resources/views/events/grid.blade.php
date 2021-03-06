@extends('app')

@section('title','Events')

@section('content')

	<h4>Events
		@include('events.crumbs')
	</h4>

	<div class="col-md-6">
	<a href="{!! URL::route('events.index') !!}" class="btn btn-info">Show event index</a>
    <a href="{!! URL::route('events.week') !!}" class="btn btn-info">Show week's events</a>
	<a href="{!! URL::route('events.create') !!}" class="btn btn-primary">Add an event</a>	<a href="{!! URL::route('series.create') !!}" class="btn btn-primary">Add an event series</a>
	</div>

	<!-- NAV / FILTER -->
	<div id="filters-container" class="row tab-content filters-content">
		<div class="col-sm-6">

			<a href="#" id="filters" class="btn btn-primary">Filters <span id="filters-toggle" class="glyphicon @if (!$hasFilter) glyphicon-chevron-down @else glyphicon-chevron-up @endif"></span></a>

			{!! Form::open(['route' => ['events.grid'], 'method' => 'GET']) !!}

			<div id="filter-list" @if (!$hasFilter)style="display: none"@endif >
			<!-- BEGIN: FILTERS -->

				<div class="form-group col-sm-3">
					{!! Form::label('filter_name','Filter By Name') !!}
					{!! Form::text('filter_name', (isset($filters['filter_name']) ? $filters['filter_name'] : NULL), ['class' =>'form-control']) !!}
				</div>

				<div class="form-group col-sm-2">
					{!! Form::label('filter_venue','Filter By Venue') !!}
                    <?php $venues = [''=>''] + App\Entity::getVenues()->pluck('name','name')->all();?>
					{!! Form::select('filter_venue', $venues, (isset($filters['filter_venue']) ? $filters['filter_venue'] : NULL), ['data-width' => '100%','class' =>'form-control select2', 'data-placeholder' => 'Select a venue']) !!}
				</div>

				<div class="form-group col-sm-2">
					{!! Form::label('filter_tag','Filter By Tag') !!}
                    <?php $tags =  [''=>'&nbsp;'] + App\Tag::orderBy('name','ASC')->pluck('name', 'name')->all();?>
					{!! Form::select('filter_tag', $tags, (isset($filters['filter_tag']) ? $filters['filter_tag'] : NULL), ['data-width' => '100%','class' =>'form-control select2', 'data-placeholder' => 'Select a tag']) !!}
				</div>

				<div class="form-group col-sm-2">
					{!! Form::label('filter_related','Filter By Related') !!}
                    <?php $related = [''=>''] + App\Entity::orderBy('name','ASC')->pluck('name','name')->all();?>
					{!! Form::select('filter_related', $related, (isset($filters['filter_related']) ? $filters['filter_related'] : NULL), ['data-width' => '100%','class' =>'form-control select2', 'data-placeholder' => 'Select an entity']) !!}
				</div>

				<div class="form-group col-sm-2">
					{!! Form::label('filter_rpp','RPP') !!}
                    <?php $rpp_options =  [''=>'&nbsp;', 5 => 5, 10 => 10, 25 => 25, 100 => 100, 1000 => 1000];?>
					{!! Form::select('filter_rpp', $rpp_options, (isset($filters['filter_rpp']) ? $filters['filter_rpp'] : NULL), ['class' =>'form-control auto-submit']) !!}
				</div>

				<div class="col-sm-2">
					<div class="btn-group col-sm-1">
						{!! Form::submit('Filter',  ['class' =>'btn btn-primary btn-sm btn-tb', 'id' => 'primary-filter-submit']) !!}

						{!! Form::close() !!}

						{!! Form::open(['route' => ['events.reset'], 'method' => 'GET']) !!}
						{!! Form::hidden('redirect','events.grid') !!}
						{!! Form::submit('Reset',  ['class' =>'btn btn-primary btn-sm btn-tb', 'id' => 'primary-filter-reset']) !!}
						{!! Form::close() !!}
					</div>
				</div>
			</div>

		</div>
		<!-- END: FILTERS -->
	</div>

	<br style="clear: left;"/>

	<div class="row">

	@if (isset($events) && count($events) > 0)
	<div class="col-lg-12">
		<div class="bs-component">
			<div class="panel panel-info">

				<div class="panel-heading">
					<h3 class="panel-title">Events</h3>
				</div>

				<div class="panel-body">
					<div style="display: grid; grid-template-columns: repeat(8, 1fr);  grid-auto-rows: minmax(100px, auto);">
					@foreach ($events as $event)
						@include('events.cell', ['event' => $event])
					@endforeach
					</div>
					{!! $events->appends(['sort_by' => $sortBy,
										'rpp' => $rpp,
										'filter_venue' => isset($filters['filter_venue']) ? $filters['filter_venue'] : NULL,
										'filter_tag' => isset($filters['filter_tag']) ? $filters['filter_tag'] : NULL,
										'filter_name' => isset($filters['filter_name']) ? $filters['filter_name'] : NULL,
										'filter_related' => isset($filters['filter_related']) ? $filters['filter_related'] : NULL,
					])->render() !!}
				</div>

			</div>
		</div>
	</div>
	@endif

	</div>

@stop


@section('footer')
	<script>
        $(document).ready(function() {
            $('#filters').click(function () {
                $('#filter-list').toggle();
                if ($('#filters-toggle').hasClass('glyphicon-chevron-down'))
                {
                    $('#filters-toggle').removeClass('glyphicon-chevron-down');
                    $('#filters-toggle').addClass('glyphicon-chevron-up');
                } else {
                    $('#filters-toggle').removeClass('glyphicon-chevron-up');
                    $('#filters-toggle').addClass('glyphicon-chevron-down');
                }
            });
        });
	</script>
@endsection
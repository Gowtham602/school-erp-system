@extends('layouts.app')

@section('content')

<h5>{{ $student->name }} - History</h5>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Class</th>
            <th>Academic Year</th>
        </tr>
    </thead>

    <tbody>
        @foreach($student->histories as $h)
        <tr>
            <td>{{ $h->class->name }}</td>
            <td>{{ $h->academic_year }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
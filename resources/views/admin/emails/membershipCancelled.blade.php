@extends('admin.layouts.minty')

@section('content')
    @include('admin.minty.contentStart')
    <tr>
        <td class="title">
            Hello {{ $customer_name }},
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">
            This is to confirm that your membership has been cancelled on {{ $cancelled_on }}.
        </td>
    </tr>
    <tr>
        <td width="100%" height="20"></td>
    </tr>
    @include('admin.minty.signature')

    @include('admin.minty.contentEnd')
@stop
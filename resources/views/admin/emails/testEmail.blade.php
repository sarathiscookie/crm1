@extends('admin.layouts.minty')

@section('content')
    @include('admin.minty.contentStart')
    <tr>
        <td class="title">Name:</td>
        <td>Test customer name</td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="title">Email:</td>
        <td>test@gmail.com</td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td class="title">Subject:</td>
        <td>{{ $subject }}</td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">Contents:</td>
        <td>It's a test mail</td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    @include('admin.minty.signature')

    @include('admin.minty.contentEnd')
@stop
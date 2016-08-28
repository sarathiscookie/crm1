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
            Welcome back.
        </td>
    </tr>
    <tr>
        <td class="paragraph">
            We kindly request you to give us your feedback for your order {{ $orderId }} by clicking below url. <br>
            <a href="#">Click here to submit your feedback</a>
        </td>
    </tr>
    <tr>
        <td width="100%" height="20"></td>
    </tr>
    @include('admin.minty.signature')

    @include('admin.minty.contentEnd')
@stop
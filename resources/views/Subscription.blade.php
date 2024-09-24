@extends('layouts.nav2')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="flex-grow-1 d-flex justify-content-center">
            <h1 class="text-center my-2">Subscription</h1>
        </div>
        <div style="width: 75px;"></div>
    </div>
</div>
@if ($users->role_id == 1)
    <div class="col-md-8" style="margin: auto; margin-top: 40px">
        <table class="table table-bordered" >
            <thead>
                <tr class="table-primary">
                    <th scope="col">Free</th>
                    <th scope="col">Business</th>
                    <th scope="col">Profesional</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-light">
                    <td>
                        <p>
                            15 swipes a day. ✅<br/>
                            Join communities. ✅<br/>
                            ❌<br/>
                            ❌<br/>
                        </p>
                    </td>
                    <td>
                        <p>
                            50 swipes a day. ✅<br/>
                            Create 5 communities. ✅<br/>
                            Filter jobs. ✅<br/>
                            ❌<br/>
                            Rp 200.000,00/30 days
                        </p>
                    </td>
                    <td>
                        <p>
                            Unlimited swipes. ✅<br/>
                            Create unlimited communities. ✅<br/>
                            Filter jobs. ✅<br/>
                            Best chance to get more projects. ✅<br/>
                            Rp 500.000,00/30 days
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Free</td>
                    <td>
                        @if ($users->plan == "Business")
                            <p>
                                This is the current plan.<br/>
                                Valid until: {{$users->subscribe_until}}.
                            </p>
                        @elseif ($users->plan == "Professional")
                            You already subscribe<br/>
                            to the Professional plan.
                        @else
                            <form action="/business"method="POST">
                                @csrf
                                <button type="submit">Business</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if ($users->plan == "Professional")
                            <p>
                                This is the current plan.<br/>
                                Valid until: {{$users->subscribe_until}}.
                            </p>
                        @else
                            <form action="/professional"method="POST">
                                @csrf
                                <button type="submit">Profesional</button>
                            </form>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <div class="col-md-8" style="margin: auto; margin-top: 40px">
        <table class="table table-bordered" >
            <thead>
                <tr class="table-primary">
                    <th scope="col">Free</th>
                    <th scope="col">Business</th>
                    <th scope="col">Profesional</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-light">
                    <td>
                        <p>
                            15 swipes a day. ✅<br/>
                            1 jost post at a time. ✅<br/>
                            ❌<br/>
                            ❌<br/>
                        </p>
                    </td>
                    <td>
                        <p>
                            50 swipes a day. ✅<br/>
                            10 job posts at a time. ✅<br/>
                            Filter freelancers. ✅<br/>
                            ❌<br/>
                            Rp 200.000,00/30 days
                        </p>
                    </td>
                    <td>
                        <p>
                            Unlimited swipes ✅<br/>
                            50 job posts at a time. ✅<br/>
                            Filter freelancers. ✅<br/>
                            Extended ad duration. ✅<br/>
                            Rp 500.000,00/30 days
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Free</td>
                    <td>
                        @if ($users->plan == "Business")
                            <p>
                                This is the current plan.<br/>
                                Valid until: {{$users->subscribe_until}}.
                            </p>
                        @elseif ($users->plan == "Professional")
                                You already subscribe<br/>
                                to the Professional plan.
                        @else
                            <form action="/business"method="POST">
                                @csrf
                                <button type="submit">Business</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if ($users->plan == "Professional")
                            <p>
                                This is the current plan.<br/>
                                Valid until: {{$users->subscribe_until}}.
                            </p>
                        @else
                            <form action="/professional"method="POST">
                                @csrf
                                <button type="submit">Profesional</button>
                            </form>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

@endsection

@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>User Details
                        <a href="{{ url(route('list_users')) }}" class="btn btn-primary float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{$member->name}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$member->email}}</td>
                            </tr>

                            <tr>
                                @php
                                    $imgTag = '-';
                                    if(isset($member->profile_image) && !empty($member->profile_image)) {
                                        $path = public_path('user_images/'.$member->profile_image);
                                        $isExists = file_exists($path);
                                        if($isExists) {
                                            $imgTag = '<img src="/user_images/'.$member->profile_image.'" width="128px">';
                                        }
                                    }
                                @endphp
                                <td>Profile Image</td>
                                <td>{!! $imgTag !!}</td>
                            </tr>

                            <tr>
                                <td>Profile Headline</td>
                                <td>{{$member->headline}}</td>
                            </tr>
                            <tr>
                                <td>Skills Summary</td>
                                <td>{{$member->skill_summary}}</td>
                            </tr>
                            
                            <tr>
                                <td>Currency</td>
                                <td>{{$member->getCurrency->symbol}} {{$member->getCurrency->code}} {{$member->getCurrency->title}}</td>
                            </tr>
                            <tr>
                                <td>Hourly Rate</td>
                                <td>{{ number_format($member->hourly_rate, 2) }}</td>
                            </tr>                                                         
                        </tbody>
                    </table>
                    
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td colspan=3><h5>System Currency Conversion</h5></td>
                            </tr>
                            <tr>
                                <td>From</td>
                                <td>
                                    <input type="hidden" id="system_hourly_rate" name="system_hourly_rate" value="{{ $member->hourly_rate}}" />
                                    @isset($member->getCurrency->code)
                                            @if ($member->getCurrency->code)
                                                <p id="system_hourly_rate_str">{{$member->getCurrency->symbol}} {{$member->getCurrency->title}}</p>
                                                <input type="hidden" id="system_from_currency" name="system_from_currency" value="{{$member->getCurrency->code}}" />
                                            @else
                                                <input type="hidden" id="system_from_currency" name="system_from_currency" value=0 />
                                            @endif
                                    @endisset
                                    
                                </td>
                                <td><p>{{ number_format($member->hourly_rate, 2) }}</p></td>
                            </tr>
                            <tr>
                                <td>To</td>
                                <td>
                                    <select class="form-select" aria-label="Default select example" onchange="sysConversion(this)" name="system_to_currency">
                                            <option value=0>Select To Currency</option>
                                            @isset($currencies)
                                                @foreach ($currencies as $cur)
                                                    <option value="{{$cur->code}}">{{$cur->symbol}} {{$cur->title}}</option>
                                                @endforeach
                                            @endisset
                                    </select>
                                </td>
                                <td><p id="system_conversion"></p></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td colspan=3><h5>Thirdparty Currency Conversion</h5></td>
                            </tr>
                            <tr>
                                <td>From</td>
                                <td>
                                    <input type="hidden" id="systemHourlyRate" name="systemHourlyRate" value="{{ $member->hourly_rate}}" />
                                    @isset($member->getCurrency->code)
                                            @if ($member->getCurrency->code)
                                                <p id="systemHourlyRateStr">{{$member->getCurrency->symbol}} {{$member->getCurrency->title}}</p>
                                                <input type="hidden" id="systemFromCurrency" name="systemFromCurrency" value="{{$member->getCurrency->code}}" />
                                            @else
                                                <input type="hidden" id="systemFromCurrency" name="systemFromCurrency" value=0 />
                                            @endif
                                    @endisset
                                    
                                </td>
                                <td><p>{{ number_format($member->hourly_rate, 2) }}</p></td>
                            </tr>
                            <tr>
                                <td>To</td>
                                <td>
                                    <select class="form-select" aria-label="Default select example" onchange="thirdPartyConversion(this)" name="thirdPartyToCurrency">
                                            <option value=0>Select To Currency</option>
                                            @isset($currencies)
                                                @foreach ($currencies as $cur)
                                                    <option value="{{$cur->code}}">{{$cur->symbol}} {{$cur->title}}</option>
                                                @endforeach
                                            @endisset
                                    </select>
                                </td>
                                <td><p id="thirdParty_conversion"></p></td>
                            </tr>
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        // System Currency Conversion
        const sysConversion = (obj) => {
            var system_from_currency    = $("#system_from_currency").val();
            var system_to_currency      = $(obj).val();
            var system_hourly_rate      = $("#system_hourly_rate").val();

            if(system_from_currency == 0 || system_to_currency == 0) {
                $("#system_conversion").html(0);
                alert("Please select System To Currency");
            } else {
                var request = $.ajax({
                    url: "{{ url(route('get_system_currency_conversion')) }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        system_from_currency: system_from_currency,
                        system_to_currency: system_to_currency,
                        system_hourly_rate: system_hourly_rate
                    },
                    dataType: "json"
                });

                request.done(function(response) {
                    if (response.data) {
                        $("#system_conversion").html(response.data);
                    } else {
                        alert(JSON.stringify(response.msg));
                    }
                });
                request.fail(function(jqXHR) {
                    alert( "Request failed: " + JSON.stringify(jqXHR) );
                });
                return false;
            }
        }
        
        // Thirdparty Currency Conversion
        const thirdPartyConversion = (obj) => {
            var system_from_currency    = $("#systemFromCurrency").val();
            var thirdPartyToCurrency    = $(obj).val();
            var system_hourly_rate      = $("#system_hourly_rate").val();
            
            if(system_from_currency == 0 || thirdPartyToCurrency == 0) {
                $("#thirdParty_conversion").html(0);
                alert("Please select ThirdParty Currency");
            } else {
                var request = $.ajax({
                    url: "{{ url(route('get_external_currency_conversion')) }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        system_from_currency: system_from_currency,
                        thirdPartyToCurrency: thirdPartyToCurrency,
                        system_hourly_rate: system_hourly_rate
                    },
                    dataType: "json"
                });

                request.done(function(response) {
                    if (response.data) {
                        $("#thirdParty_conversion").html(response.data);
                    } else {
                        alert(JSON.stringify(response.msg));
                    }
                });
                request.fail(function(jqXHR) {
                    alert( "Request failed: " + JSON.stringify(jqXHR) );
                });
                return false;
            }
        }        
</script>    
@endsection
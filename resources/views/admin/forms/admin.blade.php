@extends('layouts.admin')

@section('content')
    @include('partials.admin.form.init-admin')
    <div class="row mb-5">
     <div class="col-md-6 fv-row">
        <label class="required fs-5 fw-bold mb-2">Full Name</label>
            @if(isset($user))
            <input type="hidden" name="id" value="{{$user->id}}"/>
            @endif
            <input min="3" class="form-control" value="{{isset($user) ? $user->full_name:old('full_name')}}" type="text" name="full_name" required>

        </div>
        
    <div class="col-md-6 fv-row">
        <label class="required fs-5 fw-bold mb-2">DOB</label>
      
            <?php 
            $time = strtotime("-4 year", time());
            $date = date("Y-m-d", $time);
            ?>
            <input id="dob" max="{{$date}}" onfocus="(this.type='date')" onblur="setDateFormat(this.value)" class="form-control" value="{{isset($user)?$user->dob:old('dob')}}" type="text" name="dob">

        </div>
    </div>
    <div class="row mb-5">
     
        <div class="col-md-6 fv-row">
        <label class="required fs-5 fw-bold mb-2">Country Code</label>
        <select id="country_code" name="country_code" data-control="select2" data-placeholder="Select country code..." class="form-select">
                    <option data-countrycode="DZ" value="213">Algeria (+213)</option>
                    <option data-countrycode="AD" value="376">Andorra (+376)</option>
                    <option data-countrycode="AO" value="244">Angola (+244)</option>
                    <option data-countrycode="AI" value="1264">Anguilla (+1264)</option>
                    <option data-countrycode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                    <option data-countrycode="AR" value="54">Argentina (+54)</option>
                    <option data-countrycode="AM" value="374">Armenia (+374)</option>
                    <option data-countrycode="AW" value="297">Aruba (+297)</option>
                    <option data-countrycode="AU" value="61">Australia (+61)</option>
                    <option data-countrycode="AT" value="43">Austria (+43)</option>
                    <option data-countrycode="AZ" value="994">Azerbaijan (+994)</option>
                    <option data-countrycode="BS" value="1242">Bahamas (+1242)</option>
                    <option data-countrycode="BH" value="973">Bahrain (+973)</option>
                    <option data-countrycode="BD" value="880">Bangladesh (+880)</option>
                    <option data-countrycode="BB" value="1246">Barbados (+1246)</option>
                    <option data-countrycode="BY" value="375">Belarus (+375)</option>
                    <option data-countrycode="BE" value="32">Belgium (+32)</option>
                    <option data-countrycode="BZ" value="501">Belize (+501)</option>
                    <option data-countrycode="BJ" value="229">Benin (+229)</option>
                    <option data-countrycode="BM" value="1441">Bermuda (+1441)</option>
                    <option data-countrycode="BT" value="975">Bhutan (+975)</option>
                    <option data-countrycode="BO" value="591">Bolivia (+591)</option>
                    <option data-countrycode="BA" value="387">Bosnia Herzegovina (+387)</option>
                    <option data-countrycode="BW" value="267">Botswana (+267)</option>
                    <option data-countrycode="BR" value="55">Brazil (+55)</option>
                    <option data-countrycode="BN" value="673">Brunei (+673)</option>
                    <option data-countrycode="BG" value="359">Bulgaria (+359)</option>
                    <option data-countrycode="BF" value="226">Burkina Faso (+226)</option>
                    <option data-countrycode="BI" value="257">Burundi (+257)</option>
                    <option data-countrycode="KH" value="855">Cambodia (+855)</option>
                    <option data-countrycode="CM" value="237">Cameroon (+237)</option>
                    <option data-countrycode="CA" value="1">Canada (+1)</option>
                    <option data-countrycode="CV" value="238">Cape Verde Islands (+238)</option>
                    <option data-countrycode="KY" value="1345">Cayman Islands (+1345)</option>
                    <option data-countrycode="CF" value="236">Central African Republic (+236)</option>
                    <option data-countrycode="CL" value="56">Chile (+56)</option>
                    <option data-countrycode="CN" value="86">China (+86)</option>
                    <option data-countrycode="CO" value="57">Colombia (+57)</option>
                    <option data-countrycode="KM" value="269">Comoros (+269)</option>
                    <option data-countrycode="CG" value="242">Congo (+242)</option>
                    <option data-countrycode="CK" value="682">Cook Islands (+682)</option>
                    <option data-countrycode="CR" value="506">Costa Rica (+506)</option>
                    <option data-countrycode="HR" value="385">Croatia (+385)</option>
                    <option data-countrycode="CU" value="53">Cuba (+53)</option>
                    <option data-countrycode="CY" value="90392">Cyprus North (+90392)</option>
                    <option data-countrycode="CY" value="357">Cyprus South (+357)</option>
                    <option data-countrycode="CZ" value="42">Czech Republic (+42)</option>
                    <option data-countrycode="DK" value="45">Denmark (+45)</option>
                    <option data-countrycode="DJ" value="253">Djibouti (+253)</option>
                    <option data-countrycode="DM" value="1809">Dominica (+1809)</option>
                    <option data-countrycode="DO" value="1809">Dominican Republic (+1809)</option>
                    <option data-countrycode="EC" value="593">Ecuador (+593)</option>
                    <option data-countrycode="EG" value="20">Egypt (+20)</option>
                    <option data-countrycode="SV" value="503">El Salvador (+503)</option>
                    <option data-countrycode="GQ" value="240">Equatorial Guinea (+240)</option>
                    <option data-countrycode="ER" value="291">Eritrea (+291)</option>
                    <option data-countrycode="EE" value="372">Estonia (+372)</option>
                    <option data-countrycode="ET" value="251">Ethiopia (+251)</option>
                    <option data-countrycode="FK" value="500">Falkland Islands (+500)</option>
                    <option data-countrycode="FO" value="298">Faroe Islands (+298)</option>
                    <option data-countrycode="FJ" value="679">Fiji (+679)</option>
                    <option data-countrycode="FI" value="358">Finland (+358)</option>
                    <option data-countrycode="FR" value="33">France (+33)</option>
                    <option data-countrycode="GF" value="594">French Guiana (+594)</option>
                    <option data-countrycode="PF" value="689">French Polynesia (+689)</option>
                    <option data-countrycode="GA" value="241">Gabon (+241)</option>
                    <option data-countrycode="GM" value="220">Gambia (+220)</option>
                    <option data-countrycode="GE" value="7880">Georgia (+7880)</option>
                    <option data-countrycode="DE" value="49">Germany (+49)</option>
                    <option data-countrycode="GH" value="233">Ghana (+233)</option>
                    <option data-countrycode="GI" value="350">Gibraltar (+350)</option>
                    <option data-countrycode="GR" value="30">Greece (+30)</option>
                    <option data-countrycode="GL" value="299">Greenland (+299)</option>
                    <option data-countrycode="GD" value="1473">Grenada (+1473)</option>
                    <option data-countrycode="GP" value="590">Guadeloupe (+590)</option>
                    <option data-countrycode="GU" value="671">Guam (+671)</option>
                    <option data-countrycode="GT" value="502">Guatemala (+502)</option>
                    <option data-countrycode="GN" value="224">Guinea (+224)</option>
                    <option data-countrycode="GW" value="245">Guinea - Bissau (+245)</option>
                    <option data-countrycode="GY" value="592">Guyana (+592)</option>
                    <option data-countrycode="HT" value="509">Haiti (+509)</option>
                    <option data-countrycode="HN" value="504">Honduras (+504)</option>
                    <option data-countrycode="HK" value="852">Hong Kong (+852)</option>
                    <option data-countrycode="HU" value="36">Hungary (+36)</option>
                    <option data-countrycode="IS" value="354">Iceland (+354)</option>
                    <option data-countrycode="IN" value="91">India (+91)</option>
                    <option data-countrycode="ID" value="62">Indonesia (+62)</option>
                    <option data-countrycode="IR" value="98">Iran (+98)</option>
                    <option data-countrycode="IQ" value="964" selected>Iraq (+964)</option>
                    <option data-countrycode="IE" value="353">Ireland (+353)</option>
                    <option data-countrycode="IL" value="972">Israel (+972)</option>
                    <option data-countrycode="IT" value="39">Italy (+39)</option>
                    <option data-countrycode="JM" value="1876">Jamaica (+1876)</option>
                    <option data-countrycode="JP" value="81">Japan (+81)</option>
                    <option data-countrycode="JO" value="962">Jordan (+962)</option>
                    <option data-countrycode="KZ" value="7">Kazakhstan (+7)</option>
                    <option data-countrycode="KE" value="254">Kenya (+254)</option>
                    <option data-countrycode="KI" value="686">Kiribati (+686)</option>
                    <option data-countrycode="KP" value="850">Korea North (+850)</option>
                    <option data-countrycode="KR" value="82">Korea South (+82)</option>
                    <option data-countrycode="KW" value="965">Kuwait (+965)</option>
                    <option data-countrycode="KG" value="996">Kyrgyzstan (+996)</option>
                    <option data-countrycode="LA" value="856">Laos (+856)</option>
                    <option data-countrycode="LV" value="371">Latvia (+371)</option>
                    <option data-countrycode="LB" value="961">Lebanon (+961)</option>
                    <option data-countrycode="LS" value="266">Lesotho (+266)</option>
                    <option data-countrycode="LR" value="231">Liberia (+231)</option>
                    <option data-countrycode="LY" value="218">Libya (+218)</option>
                    <option data-countrycode="LI" value="417">Liechtenstein (+417)</option>
                    <option data-countrycode="LT" value="370">Lithuania (+370)</option>
                    <option data-countrycode="LU" value="352">Luxembourg (+352)</option>
                    <option data-countrycode="MO" value="853">Macao (+853)</option>
                    <option data-countrycode="MK" value="389">Macedonia (+389)</option>
                    <option data-countrycode="MG" value="261">Madagascar (+261)</option>
                    <option data-countrycode="MW" value="265">Malawi (+265)</option>
                    <option data-countrycode="MY" value="60">Malaysia (+60)</option>
                    <option data-countrycode="MV" value="960">Maldives (+960)</option>
                    <option data-countrycode="ML" value="223">Mali (+223)</option>
                    <option data-countrycode="MT" value="356">Malta (+356)</option>
                    <option data-countrycode="MH" value="692">Marshall Islands (+692)</option>
                    <option data-countrycode="MQ" value="596">Martinique (+596)</option>
                    <option data-countrycode="MR" value="222">Mauritania (+222)</option>
                    <option data-countrycode="YT" value="269">Mayotte (+269)</option>
                    <option data-countrycode="MX" value="52">Mexico (+52)</option>
                    <option data-countrycode="FM" value="691">Micronesia (+691)</option>
                    <option data-countrycode="MD" value="373">Moldova (+373)</option>
                    <option data-countrycode="MC" value="377">Monaco (+377)</option>
                    <option data-countrycode="MN" value="976">Mongolia (+976)</option>
                    <option data-countrycode="MS" value="1664">Montserrat (+1664)</option>
                    <option data-countrycode="MA" value="212">Morocco (+212)</option>
                    <option data-countrycode="MZ" value="258">Mozambique (+258)</option>
                    <option data-countrycode="MN" value="95">Myanmar (+95)</option>
                    <option data-countrycode="NA" value="264">Namibia (+264)</option>
                    <option data-countrycode="NR" value="674">Nauru (+674)</option>
                    <option data-countrycode="NP" value="977">Nepal (+977)</option>
                    <option data-countrycode="NL" value="31">Netherlands (+31)</option>
                    <option data-countrycode="NC" value="687">New Caledonia (+687)</option>
                    <option data-countrycode="NZ" value="64">New Zealand (+64)</option>
                    <option data-countrycode="NI" value="505">Nicaragua (+505)</option>
                    <option data-countrycode="NE" value="227">Niger (+227)</option>
                    <option data-countrycode="NG" value="234">Nigeria (+234)</option>
                    <option data-countrycode="NU" value="683">Niue (+683)</option>
                    <option data-countrycode="NF" value="672">Norfolk Islands (+672)</option>
                    <option data-countrycode="NP" value="670">Northern Marianas (+670)</option>
                    <option data-countrycode="NO" value="47">Norway (+47)</option>
                    <option data-countrycode="OM" value="968">Oman (+968)</option>
                    <option data-countrycode="PW" value="680">Palau (+680)</option>
                    <option data-countrycode="PW" value="92">Pak (+92)</option>
                    <option data-countrycode="PA" value="507">Panama (+507)</option>
                    <option data-countrycode="PG" value="675">Papua New Guinea (+675)</option>
                    <option data-countrycode="PY" value="595">Paraguay (+595)</option>
                    <option data-countrycode="PE" value="51">Peru (+51)</option>
                    <option data-countrycode="PH" value="63">Philippines (+63)</option>
                    <option data-countrycode="PL" value="48">Poland (+48)</option>
                    <option data-countrycode="PT" value="351">Portugal (+351)</option>
                    <option data-countrycode="PR" value="1787">Puerto Rico (+1787)</option>
                    <option data-countrycode="QA" value="974">Qatar (+974)</option>
                    <option data-countrycode="RE" value="262">Reunion (+262)</option>
                    <option data-countrycode="RO" value="40">Romania (+40)</option>
                    <option data-countrycode="RU" value="7">Russia (+7)</option>
                    <option data-countrycode="RW" value="250">Rwanda (+250)</option>
                    <option data-countrycode="SM" value="378">San Marino (+378)</option>
                    <option data-countrycode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                    <option data-countrycode="SA" value="966">Saudi Arabia (+966)</option>
                    <option data-countrycode="SN" value="221">Senegal (+221)</option>
                    <option data-countrycode="CS" value="381">Serbia (+381)</option>
                    <option data-countrycode="SC" value="248">Seychelles (+248)</option>
                    <option data-countrycode="SL" value="232">Sierra Leone (+232)</option>
                    <option data-countrycode="SG" value="65">Singapore (+65)</option>
                    <option data-countrycode="SK" value="421">Slovak Republic (+421)</option>
                    <option data-countrycode="SI" value="386">Slovenia (+386)</option>
                    <option data-countrycode="SB" value="677">Solomon Islands (+677)</option>
                    <option data-countrycode="SO" value="252">Somalia (+252)</option>
                    <option data-countrycode="ZA" value="27">South Africa (+27)</option>
                    <option data-countrycode="ES" value="34">Spain (+34)</option>
                    <option data-countrycode="LK" value="94">Sri Lanka (+94)</option>
                    <option data-countrycode="SH" value="290">St. Helena (+290)</option>
                    <option data-countrycode="KN" value="1869">St. Kitts (+1869)</option>
                    <option data-countrycode="SC" value="1758">St. Lucia (+1758)</option>
                    <option data-countrycode="SD" value="249">Sudan (+249)</option>
                    <option data-countrycode="SR" value="597">Suriname (+597)</option>
                    <option data-countrycode="SZ" value="268">Swaziland (+268)</option>
                    <option data-countrycode="SE" value="46">Sweden (+46)</option>
                    <option data-countrycode="CH" value="41">Switzerland (+41)</option>
                    <option data-countrycode="SI" value="963">Syria (+963)</option>
                    <option data-countrycode="TW" value="886">Taiwan (+886)</option>
                    <option data-countrycode="TJ" value="7">Tajikstan (+7)</option>
                    <option data-countrycode="TH" value="66">Thailand (+66)</option>
                    <option data-countrycode="TG" value="228">Togo (+228)</option>
                    <option data-countrycode="TO" value="676">Tonga (+676)</option>
                    <option data-countrycode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                    <option data-countrycode="TN" value="216">Tunisia (+216)</option>
                    <option data-countrycode="TR" value="90">Turkey (+90)</option>
                    <option data-countrycode="TM" value="7">Turkmenistan (+7)</option>
                    <option data-countrycode="TM" value="993">Turkmenistan (+993)</option>
                    <option data-countrycode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                    <option data-countrycode="TV" value="688">Tuvalu (+688)</option>
                    <option data-countrycode="UG" value="256">Uganda (+256)</option>
                    <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
                    <option data-countrycode="UA" value="380">Ukraine (+380)</option>
                    <option data-countrycode="AE" value="971">United Arab Emirates (+971)</option>
                    <option data-countrycode="UY" value="598">Uruguay (+598)</option>
                    <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
                    <option data-countrycode="UZ" value="7">Uzbekistan (+7)</option>
                    <option data-countrycode="VU" value="678">Vanuatu (+678)</option>
                    <option data-countrycode="VA" value="379">Vatican City (+379)</option>
                    <option data-countrycode="VE" value="58">Venezuela (+58)</option>
                    <option data-countrycode="VN" value="84">Vietnam (+84)</option>
                    <option data-countrycode="VG" value="84">Virgin Islands - British (+1284)</option>
                    <option data-countrycode="VI" value="84">Virgin Islands - US (+1340)</option>
                    <option data-countrycode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                    <option data-countrycode="YE" value="969">Yemen (North)(+969)</option>
                    <option data-countrycode="YE" value="967">Yemen (South)(+967)</option>
                    <option data-countrycode="ZM" value="260">Zambia (+260)</option>
                    <option data-countrycode="ZW" value="263">Zimbabwe (+263)</option>
        </select>
        </div>
        <div class="col-md-6 fv-row">
            <label class="required fs-5 fw-bold mb-2">Phone Number</label>
                <input placeholder="Please input number without country code" type="number"   onblur="setCountryCode(this.value)" id="username1" class="form-control" value="{{isset($user)? '0'.substr($user->phone,5):old('phone')}}"  name="phone2" required="required">
                <input type="hidden" name="phone" id="phone">
        </div>
        
    </div>

    <div class="row mb-5">
    <div class="col-md-6 fv-row">
        <label class="required fs-5 fw-bold mb-2">Gender</label>
            
        <select name="gender" data-control="select2" data-placeholder="Select gender..." class="form-select">
                
                <option  value='Male' selected>Male</option>
                <option value='Female'>Female</option>
                <option value='Others'>Others</option>
            </select>  

        </div>
        @if (strpos(Route::getCurrentRoute()->getActionName(), 'create') == false)
    
        @foreach (['email' => 'email'] as $attribute => $type)
        
            @include('partials.admin.form.text-admin')
        @endforeach
        @endif



@if (strpos(Route::getCurrentRoute()->getActionName(), 'create') !== false)
    @foreach (['email' => 'email', 'password' => 'password', 'password_confirmation' => 'password'] as $attribute => $type)
        
        @include('partials.admin.form.text-admin')

    @endforeach
@endif



    <div class="col-md-6 fv-row mt-4">
        <label class="required fs-5 fw-bold mb-2">Country</label>
    
        <select data-control="select2" data-placeholder="Select country ..." class="form-select"  type="text" name='country' required>
            
            <option value="Iraq" selected="selected">Iraq</option>
           
        </select>
    </div>

    <div class="col-md-6 fv-row mt-4">
        <label class="fs-5 fw-bold mb-2">City</label>
        <select data-control="select2" data-placeholder="Select country ..." class="form-select"  type="text" name="city">
            @foreach($cityObj as $city)
            @if($city->lang_name=='English')
                <option <?= isset($user) && $user->city == $city->city_name ? 'selected' : '' ?> value="{{$city->city_name}}">{{$city->city_name}}</option>
            @endif
            @endforeach
        </select>
    </div>
</div>
<!-- <div class="field">
    <label class="label">Location*</label>
    <input type="hidden" name="" id="locationhidden">
    <div class="control">
          <input class="input is-large" value="{{isset($user)?$user->location:''}}" type="text" name="location" id="location" required>
          <input type="hidden" name="users_form" value="users_form">
    </div>
   
</div> -->
<!-- <div id="map-canvas"></div> -->
    @include('partials.admin.form.submit-admin')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <script type="text/javascript">

/*var geocoder;
var map;
var marker;
var marker2;

function initialize() {
    geocoder = new google.maps.Geocoder();
    var
    latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
        zoom: 5,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    google.maps.event.addListener(map, 'click', function (event) {
        //alert(event.latLng);          
        geocoder.geocode({
            'latLng': event.latLng
        }, function (results, status) {
            if (status ==
                google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    alert(results[1].formatted_address);
                } else {
                    alert('No results found');
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });
    }); 

     }
    google.maps.event.addDomListener(window, 'load', initialize);*/




        getLocation();
         var div  = document.getElementById("locationhidden");
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
          div.innerHTML = "The Browser Does not Support Geolocation";
        }
      }

      function showPosition(position) {
         var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + position.coords.latitude + '%2C' + position.coords.longitude + '&language=en';

            $.getJSON(GEOCODING).done(function(location) {
                console.log(location)
            })
      document.getElementById("location").value = "Latitude: " + position.coords.latitude + "Longitude: " + position.coords.longitude;
      }

      function showError(error) {
        if(error.PERMISSION_DENIED){
            div.value = "The User have denied the request for Geolocation.";
        }
      }
      
        function setDateFormat(dt) {
            if(dt === "")
            {
                $('#dob').attr("type",'text').value = "";
                return 
            }
            //var dob = $('#dob').attr("type",'date').value;
            console.log(dt)
            const dtArr = dt.split("-");
            
            var year=dtArr[0];
            var month=dtArr[1];
            var day=dtArr[2];
            var fullDate=day+'-'+month+'-'+year;
            $('#dob').attr("type",'text');
            $('#dob').val(fullDate);

            //alert(fullDate)
            // body...
        }

        function checkDateType() {
           //var dt= $('#dob').attr();
           //alert(dt);
           $('#dob').attr("type",'date');
        }

        function setCountryCode(vl) {
           // console.log("Number part is=> "+vl);
           let letter = vl.charAt(0);
           if(letter=='0'){
            vl = vl.substring(1);
            }
            $('#phone').val('');
            var country_code =$('#country_code').val();
            var finalVal='00'+country_code+vl;
            $('#phone').val(finalVal);
            console.log($('#phone').val());
        }
    </script>
@endsection

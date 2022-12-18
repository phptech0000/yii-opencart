<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Pay';
?>
<div class="container mt-3">
    <div class="row">
        <div class="col-3">

        </div>
        <div class="col-6">
            <div class="mt-5">
                <form>
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                    <div class="mb-3 mt-3">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control mt-3" id="firstName" placeholder="Enter First Name" name="first_name">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="firstName">Last Name:</label>
                        <input type="text" class="form-control mt-3" id="lastName" placeholder="Enter Last Name" name="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control mt-3" id="email" placeholder="Enter Email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control mt-3" id="phone" placeholder="Enter Phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="street1">Street1:</label>
                        <input type="text" class="form-control mt-3" id="street1" placeholder="Enter Street1" name="street1">
                    </div>
                    <div class="mb-3">
                        <label for="street2">Street2:</label>
                        <input type="text" class="form-control mt-3" id="street2" placeholder="Enter Street2" name="street2">
                    </div>
                    <div class="mb-3">
                        <label for="zip">ZIP:</label>
                        <input type="text" class="form-control mt-3" id="zip" placeholder="Enter Zip" name="zip">
                    </div>
                    <div class="mb-3">
                        <label for="city">City:</label>
                        <input type="text" class="form-control mt-3" id="city" placeholder="Enter City" name="city">
                    </div>
                    <div class="mb-3">
                        <label for="country">Country:</label>
                        <select class="form-select mt-3" id="country_id">
                            <option value="">Please Select Country</option>
                            <?php
                                foreach($country_data as $item){
                            ?>
                                    <option value="<?= $item['country_id'] ?>"> <?= $item['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <button type="button" id="buyNow" class="btn btn-primary">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
    <link href="/web/plugin/toastr/toastr.css" rel="stylesheet" type="text/css" />
    <script src="/web/plugin/toastr/toastr.js"></script>
    <script>
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
    $(":input").change(function(){
        var name = $(this).attr("name");
        var value = $(this).val();
        localStorage.setItem(name, value);
    });
    $("select").change(function(){
        var name = "country_id";
        var value = $(this).val();
        localStorage.setItem(name, value);
    });
    $(document).ready(function(){
        var firstName = localStorage.getItem('first_name');
        var last_name = localStorage.getItem('last_name');
        var email = localStorage.getItem('email');
        var phone = localStorage.getItem('phone');
        var street1 = localStorage.getItem('street1');
        var street2 = localStorage.getItem('street2');
        var zip = localStorage.getItem('zip');
        var city = localStorage.getItem('city');
        var country_id = localStorage.getItem('country_id');
        $("#firstName").val(firstName);
        $("#lastName").val(last_name);
        $("#email").val(email);
        $("#phone").val(phone);
        $("#street1").val(street1);
        $("#street2").val(street2);
        $("#zip").val(zip);
        $("#city").val(city);
        $("#country_id").val(country_id);
    });
    $("#buyNow").click(function(){
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var street1 = $("#street1").val();
        var street2 = $("#street2").val();
        var zip = $("#zip").val();
        var city = $("#city").val();
        var country = $( "select option:selected" ).val();
        var orderId = localStorage.getItem("order_id");
        var lang = "en-EN";
        if( orderId == null || orderId == ""){
            orderId = "";
        }
        $.ajax({
            url: "",
            method: "POST",
            data: { 
                _csrf: csrfToken, 
                first_name: firstName,
                last_name: lastName,
                email: email,
                phone: phone,
                street1: street1,
                street2: street2,
                zip: zip,
                city: city,
                country: country,
                order_id: orderId,
                lang: lang,
            },
            success: function(res){
                var res_data = JSON.parse(res);
                if(res_data["status"] == "success"){
                    localStorage.clear();
                    window.location = '/success.html'
                }else{
                    var messages = res_data["message"];
                    for( var key in messages){
                        toastr["warning"](messages[key][0]);
                    }
                }
            },
            error: function(res){
                toastr["warning"]("Server Interval Error!");
            }
        })
    });
    </script>

</div>
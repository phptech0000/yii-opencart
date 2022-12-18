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
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control mt-3" id="email" placeholder="Enter Email" name="email">
                    </div>
                    <button type="button" id="buyNow" class="btn btn-primary">Buy Now</button>
                </form>
            </div>
        </div>
    </div>
    <link href="/plugin/toastr/toastr.css" rel="stylesheet" type="text/css" />
    <script src="/plugin/toastr/toastr.js"></script>
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
    };
    $(":input").change(function(){
        var name = $(this).attr("name");
        var value = $(this).val();
        localStorage.setItem(name, value);
    });
    $("#buyNow").click(function(){
        var firstName = $("#firstName").val();
        var email = $("#email").val();
        var orderId = localStorage.getItem("order_id");
        if(orderId == null || orderId == ""){
            orderId = "";
        }
        $.ajax({
            url: "",
            method: "POST",
            data: { _csrf: csrfToken, first_name: firstName, email: email, order_id: orderId},
            success: function(res){
                var res_data = JSON.parse(res);
                if(res_data["status"] == "success"){
                    localStorage.setItem("first_name", firstName);
                    localStorage.setItem("email", email);
                    localStorage.setItem("order_id", res_data["order_id"]);
                    window.location = '/checkout.html'
                }else{
                    var messages = res_data["message"];
                    for( var key in messages){
                        toastr["warning"](messages[key][0]);
                    }
                }
            },
            error: function(res){
                toastr["warning"]("Something went wrong!");
            }
        })
    });
    $(document).ready(function(){
        var firstName = localStorage.getItem('first_name');
        var email = localStorage.getItem('email');
        $("#firstName").val(firstName);
        $("#email").val(email);
    });
    </script>

</div>
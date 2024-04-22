<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Facture </title>
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-invoice.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="bg-white">
    <div class="" style="width:100%; height:3rem; background-color:purple;">
    </div>
    <!-- BEGIN: Content-->
    <div class="" style="margin-top:1rem">
        <div class="content-wrapper">
            <div class="content-body">
                <!-- app invoice View Page -->
                <section class="invoice-view-wrapper">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col-xl-9 col-12 mx-auto">
                            <div class="card invoice-print-area shadow-none">
                                <div class="card-content">
                                    <div class="card-body pb-0 mx-25">
                                        <!-- header section -->
                                        <div class="row">
                                            <div class="col-xl-4 col-md-12">
                                                <span class="invoice-number mr-50">
                                                    Reçu d'achat du {{\Carbon\Carbon::now()->format('d / m / Y')}}
                                                </span>
                                            </div>
                                        </div>
                                        <!-- logo and title -->
                                        <hr>
                                        <!-- invoice address and contact -->
                                        <div class="row invoice-info">
                                            <div class="col-6 mt-1">
                                                <h6 class="invoice-from">Vendeur</h6>
                                                <div class="mb-1">
                                                    <span>Nom complet : {{$order['seller']->fullname}}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>Login : {{$order['seller']->email}}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>Numéro de téléphone : {{$order['seller']->user->phone_number}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6 mt-1">
                                                <h6 class="invoice-to">Client</h6>
                                                <div class="mb-1">
                                                    <span>Nom complet : {{$order['buyer']->fullname}}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>Login : {{$order['buyer']->email}}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>Numéro de téléphone : {{$order['buyer']->user->phone_number}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <!-- product details table-->
                                    <div class="invoice-product-details table-responsive mx-md-25 px-2">
                                        Motif 4 Ebooks Téléchargeables
                                        <div>Prix 40$ us</div>
                                    </div>

                                    <!-- invoice subtotal -->
                                    <div class="card-body pt-0 mx-25">
                                        <hr>
                                        <div class="row">
                                            <div class="col-4 col-sm-6 mt-75">
                                                <p>Merci de votre fidélité</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
<!-- END: Body-->

</html>

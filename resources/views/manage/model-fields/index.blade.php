
@extends('iprotek_core::layout.pages.view-dashboard')
@section('logout-link','/logout')
@section('site-title', 'Model Fields')
@section('head')
    <link rel="stylesheet" href="/css/w3school/searchinput.css">
    <link rel="stylesheet" href="/css/redtable.css">
    <link rel="stylesheet" href="/css/Xpose-hover.css">
    <script src="/js/xpose/Xpose-Events.js"></script>
    <script src="/js/xlsx.full.min.js"></script>
@endsection
@section('breadcrumb')
    <!--
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Widgets</li>
    -->
@endsection
@section('content') 
  <div id="main-content">
    <?php
      $user_id = auth()->user()->id;
      $user_admin = \iProtek\Core\Models\UserAdminPayAccount::where('user_admin_id', $user_id)->first();
      $group_id = 0;
      if($user_admin){
        $group_id = $user_admin->own_proxy_group_id;
      }

    ?>
    <model-fields-view group_id="{{$group_id}}" is_data="1"></model-fields-view>  
  </div>
  
@endsection

@section('foot')
  <script>
    ActivateMenu(['menu-model-fields']);
  </script>
  <script src="/iprotek/js/manage/iprotek-data/model-fields.js"> </script>
@endsection
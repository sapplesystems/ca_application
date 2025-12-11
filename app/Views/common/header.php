<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CA Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php base_url();?>public/assets/style.css">
    <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
     
</head>

<body>
    <div class="bg-blur"></div>

    <header class="top-header">
        <div class="logo-wrap">
            <div class="logo-mark">CA</div>
            <div>
                <div class="logo-text-main">Kumar Samantaray &amp; Associates</div>
                <div class="logo-text-sub">Chartered Accountants</div>
            </div>
        </div>
        <div class="user-info">
            Welcome! <span><?= $session->get('username'); ?></span>
            <a href="<?= base_url('logout'); ?>">LOGOUT</a>
        </div>
    </header>

    <!-- NAVBAR based on ca-project functional scope -->
    <nav class="menu-bar">
        <a href="<?= base_url('work_master'); ?>" style="color:#fff;text-decoration:none">
        <div class="menu-item active">    
        Master Work List</div></a>
         <a href="<?= base_url('company_master'); ?>" style="color:#fff;text-decoration:none"><div class="menu-item">Company Master</div></a>
        <div class="menu-item">Client Master</div>
        <div class="menu-item">Invoice Management</div>
        <div class="menu-item">Receipt Notes (TDS)</div>
        <div class="menu-item">Reports &amp; Registers</div>
        <div class="menu-item">PDF Outputs</div>
    </nav>
    
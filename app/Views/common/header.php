<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CA Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url();?>public/assets/style.css">

    <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        <a href="<?= base_url('work_master'); ?>" class="menu-link">
            <div class="menu-item">Master Work List</div>
        </a>

        <a href="<?= base_url('company_master'); ?>" class="menu-link">
            <div class="menu-item">Company Master</div>
        </a>

        <a href="<?= base_url('Client_Master'); ?>" class="menu-link">
            <div class="menu-item">Client Master</div>
        </a>

        <a href="<?= base_url('InvoiceManagment'); ?>" class="menu-link">
            <div class="menu-item">Invoice Management</div>
        </a>

        <a href="<?= base_url('receipt_notes'); ?>" class="menu-link">
            <div class="menu-item">Receipt Notes (TDS)</div>
        </a>

        <a href="<?= base_url('reports_registers'); ?>" class="menu-link">
            <div class="menu-item">Reports & Registers</div>
        </a>

        <a href="<?= base_url('pdf_outputs'); ?>" class="menu-link">
            <div class="menu-item">PDF Outputs</div>
        </a>
    </nav>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname; // e.g. /company_master

        document.querySelectorAll('.menu-bar .menu-link').forEach(function(link) {
            const linkPath = new URL(link.href).pathname; // sirf path nikaalo

            if (currentPath === linkPath) {
                document
                    .querySelectorAll('.menu-bar .menu-item.active')
                    .forEach(el => el.classList.remove('active'));

                link.querySelector('.menu-item').classList.add('active');
            }
        });
    });
    </script>
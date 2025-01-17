<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $Content->title ?> - <?php echo $Config->get('site_name') ?></title>
    <style>
        body{
            background-color: #222;
            color: #f0f0f0;
            font-size: 12px;
        }
        ul.breadcrumb-block {
            padding: 10px 16px;
            list-style: none;
        }
        ul.breadcrumb-block li {
            display: inline;
            font-size: 18px;
        }
        ul.breadcrumb-block li+li:before {
            padding: 8px;
            color: black;
            content: "/\00a0";
        }
        ul.breadcrumb-block li a {
            color: #0275d8;
            text-decoration: none;
        }
        ul.breadcrumb-block li a:hover {
            color: #01447e;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php echo $render; ?>
</body>
</html>
<html>
<head>
    <title>add静态页面</title>
</head>

<body>
    in index.html<br>
    <?php
        echo $today;
    ?>
    <?php
        echo $title;
    ?>
    <br>输出变量的趋势写法:<br>
    <?php
    /**
     * 但是如今的趋势都是如下写法
     * 因为php5.5以后，默认支持这种写法
     */
    ?>
    <?=$today?>
    <?=$title?>
</body>
</html>
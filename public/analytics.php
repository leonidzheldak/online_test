<?php
require_once dirname(__DIR__) . '/config/config.php';
require 'partials/header.php';
?>
<h2>Аналитика</h2>
<div id="chartdiv" style="width:100%;height:400px;"></div>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script>
am5.ready(function() {
  var root = am5.Root.new("chartdiv");
  var chart = root.container.children.push(
    am5xy.XYChart.new(root, {})
  );
});
</script>
<?php require 'partials/footer.php'; ?>
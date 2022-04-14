<body style="overflow-x:hidden;overflow-y:hidden">
	<div id="chart-container"></div>

<script type="text/javascript" src="https://static.cryptowat.ch/assets/scripts/embed.bundle.js"></script>

<script>
var chart = new cryptowatch.Embed('bithumb', 'btckrw', {
timePeriod: '1m',
  presetColorScheme: 'delek'
});
chart.mount('#chart-container');
</script>
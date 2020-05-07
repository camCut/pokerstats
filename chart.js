console.log('hello', rankingData);

function renderRankingChart() {
  const series = Object.values(rankingData).map(item => ({name: item.name, data: [item.totalWins, item.totalSecond, item.totalThird]}));
  console.log(series);
  var myChart = Highcharts.chart('chart-container', {
    chart: {
      type: 'bar',
    },
    title: {
      text: 'Player Rankings',
    },
    xAxis: {
      categories: ['first', 'second', 'third'],
    },
    yAxis: {
      title: {
        text: 'Rankings',
      },
    },
    series: series,
  });
}

function renderRankingChart2() {
  const series = [
    {name: 'first', data: Object.values(rankingData).map(item => item.totalWins)},
    {name: 'second', data: Object.values(rankingData).map(item => item.totalSecond)},
    {name: 'third', data: Object.values(rankingData).map(item => item.totalThird)},
  ];
  Highcharts.chart('chart-container', {
    chart: {
      type: 'bar',
    },
    title: {
      text: 'Player Rankings',
    },
    xAxis: {
      categories: Object.keys(rankingData),
    },
    yAxis: {
      title: {
        text: 'Rankings',
      },
    },
    series: series,
  });
}

function renderTournamentChart() {
  const series = Object.keys(rankingData).map(name => ({
    name: name, data: tournamentData.reduce((prev, tournament) => {
      let profit = prev.length === 0 ? 0 : prev[prev.length - 1];
      if (name === tournament.winner) {
        profit += tournament.moneyFirst - tournament.buyIn;
      }
      if (name === tournament.second) {
        profit += tournament.moneySecond - tournament.buyIn;
      }
      if (name === tournament.third) {
        profit += tournament.moneyThird - tournament.buyIn;
      }
      prev.push(profit);
      return prev;
    }, []),
  }));

  Highcharts.chart('chart-container', {
    chart: {
      type: 'spline',
    },
    title: {
      text: 'Player Profit',
    },
    xAxis: {
      categories: tournamentData.map(tournament => new Date(tournament.date * 1000).toDateString()),
    },
    yAxis: {
      title: {
        text: 'Profit',
      },
    },
    series: series,
    
  });
}


document.addEventListener('DOMContentLoaded', function () {
  renderTournamentChart();
});

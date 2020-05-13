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
  const playerNames = Object.keys(rankingData);
  const series = playerNames.map(name => ({
    name: name, 
    data: getTournamentData(name),
  }));
console.log(series[1]);
  Highcharts.chart('chart-container', {
    /* plotOptions: {
      series: {
          // general options for all series
          
      },
      areaspline: {
          // shared options for all areaspline series
      }
  }, */
    chart: {
      type: 'spline',
    },
    
    title: {
      text: 'Player Profit',
    },
    xAxis: {
      labels: {
        formatter: obj => new Date(obj.value * 1000).toDateString()
      },
      //categories: tournamentData.map(tournament => new Date(tournament.date * 1000).toDateString()),
    },
    tooltip: {
      formatter: function () {
        console.log();
        return `
<b>${this.series.name}</b><br/>
Date: ${new Date(this.x * 1000).toDateString()} <br/>
Profit: ${this.y} €`;
      },
    },
    yAxis: {
      title: {
        text: 'Profit',
      },
    },
    series: series,
    
  });
}
function getTournamentData(name) {
  return tournamentData.reduce((prev, tournament) => {
    if(tournament.participants.includes(name)) {
      const playerIndex = tournament.participants.findIndex((participantName) => (participantName === name));
      let playerMoney = 0;
      let startMoney = 0;
      if(prev.length > 0){
            startMoney = prev[prev.length - 1].y;
      }
      if(playerIndex < tournament.payOut.length){
        playerMoney = tournament.payOut[playerIndex];
      }
      const profit = startMoney + playerMoney - tournament.buyIn;
      prev.push({
        x: tournament.date,
        y: profit,
      });
    }
    return prev;
  }, []);
}

document.addEventListener('DOMContentLoaded', function () {
  renderTournamentChart();
});

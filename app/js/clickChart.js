var ctx = document.getElementById("clickChart").getContext('2d');

console.log(jClickrates)

var clickChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [{
            label: "UI",
            data: jClickrates.ui,
            backgroundColor: '#52B795'
        },
        {
            label: "UX",
            data: jClickrates.ux,
            backgroundColor: '#e7607b'
        },
        {
            label: "DEV",
            data: jClickrates.dev,
            backgroundColor: '#F9E131'
        }],
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
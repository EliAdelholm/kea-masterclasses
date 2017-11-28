var ctx = document.getElementById("clickChart").getContext('2d');
var clickChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [{
            label: "UI",
            data: [214],
            backgroundColor: '#52B795'
        },
        {
            label: "UX",
            data: [312],
            backgroundColor: '#e7607b'
        },
        {
            label: "DEV",
            data: [423],
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
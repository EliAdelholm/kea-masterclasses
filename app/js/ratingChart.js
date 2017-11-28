var ctx = document.getElementById("ratingChart").getContext('2d');
var ratingChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [{
            label: "UI",
            data: [2.7],
            backgroundColor: '#52B795'
        },
        {
            label: "UX",
            data: [3.2],
            backgroundColor: '#e7607b'
        },
        {
            label: "DEV",
            data: [4.6],
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
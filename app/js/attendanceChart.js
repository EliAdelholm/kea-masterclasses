var ctx = document.getElementById("attendanceChart").getContext('2d');
var attendanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [{
            label: "UI",
            data: [12],
            backgroundColor: '#52B795'
        },
        {
            label: "UX",
            data: [19],
            backgroundColor: '#e7607b'
        },
        {
            label: "DEV",
            data: [3],
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
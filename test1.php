<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Card Animation</title>
    <style>
        /* Base Styles */
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f8ff;
            font-family: Arial, sans-serif;
        }

        .card {
            position: relative;
            width: 300px;
            height: 400px;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background 0.5s ease;
        }

        .icon {
            font-size: 64px;
            margin-bottom: 10px;
        }

        .temp {
            font-size: 32px;
            font-weight: bold;
        }

        .desc {
            margin-top: 10px;
            font-size: 18px;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background: #333;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
        }

        /* Sunny Styles */
        .sunny {
            background: linear-gradient(to top right, #ffd700 30%, #fff 70%);
        }

        .sun {
            position: absolute;
            top: -10%;
            right: -10%;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle, #fff 20%, #ffd700 80%);
            animation: spin 5s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Rainy Styles */
        .rainy {
            background: linear-gradient(to top right, #6a7480 30%, #d3d3d3 70%);
        }

        .rainy::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                45deg,
                rgba(0,0,0,0.05),
                rgba(0,0,0,0.05) 10px,
                transparent 10px,
                transparent 20px
            );
            animation: rainDrop 1s linear infinite;
        }

        @keyframes rainDrop {
            0% { transform: translateY(0); }
            100% { transform: translateY(50px); }
        }

        /* Snowy Styles */
        .snowy {
            background: linear-gradient(to top right, #87cefa 30%, #fff 70%);
        }

        .snowy::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, #fff 10%, transparent 10%);
            background-size: 5px 5px;
            opacity: 0.5;
            animation: snowFall 3s linear infinite;
        }

        @keyframes snowFall {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(100px) rotate(360deg); }
        }

        /* Common Animation */
        .card::before,
        .card::after {
            content: '';
            position: absolute;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div id="weather-app">
        <div id="weather-card" class="card sunny">
            <div class="icon"><span id="weather-icon">☀️</span></div>
            <div class="temp"><span id="weather-temp">22°C</span></div>
            <div class="desc"><span id="weather-desc">Sunny</span></div>
            <div class="sun"></div>
        </div>
        <button id="toggle-weather">切换天气</button>
    </div>

    <script>
        const weatherData = {
            sunny: {
                icon: '☀️',
                temp: '22°C',
                desc: 'Sunny',
                cardClass: 'sunny'
            },
            rainy: {
                icon: '🌧️',
                temp: '15°C',
                desc: 'Rainy',
                cardClass: 'rainy'
            },
            snowy: {
                icon: '❄️',
                temp: '5°C',
                desc: 'Snowy',
                cardClass: 'snowy'
            }
        };

        const order = ['sunny', 'rainy', 'snowy'];
        let currentIndex = 0;

        const card = document.getElementById('weather-card');
        const icon = document.getElementById('weather-icon');
        const temp = document.getElementById('weather-temp');
        const desc = document.getElementById('weather-desc');

        document.getElementById('toggle-weather').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % order.length;
            const currentWeather = weatherData[order[currentIndex]];

            card.className = `card ${currentWeather.cardClass}`;
            icon.textContent = currentWeather.icon;
            temp.textContent = currentWeather.temp;
            desc.textContent = currentWeather.desc;
        });
    </script>
</body>
</html>

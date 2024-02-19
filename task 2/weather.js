const express = require('express');
const axios = require('axios');

const app = express();
const PORT = 3000;

const API_KEY = 'YOUR_ACCUWEATHER_API_KEY';

app.get('/weather', async (req, res) => {
  try {
    const response = await axios.get(`http://dataservice.accuweather.com/currentconditions/v1/1-215854_1_AL?apikey=${API_KEY}`);
    const weatherData = response.data[0];
    res.json({
      temperature: weatherData.Temperature.Imperial.Value,
      condition: weatherData.WeatherText
    });
  } catch (error) {
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});

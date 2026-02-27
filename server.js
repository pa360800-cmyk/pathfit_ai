// server.js

const express = require("express");

const app = express();

/* ======================
   Middleware
====================== */
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

/* ======================
   Routes
====================== */
app.get("/", (req, res) => {
  res.status(200).send("🚀 Server is running successfully!");
});

/* ======================
   Error Handling
====================== */
app.use((req, res) => {
  res.status(404).json({
    success: false,
    message: "Route not found",
  });
});

/* ======================
   Server Start
====================== */
const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
  console.log(`🚀 Server running on port ${PORT}`);
});

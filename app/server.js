const express = require("express");
const { Pool } = require("pg");

const app = express();

// PostgreSQL connection
const pool = new Pool({
    connectionString: process.env.DATABASE_URL,
    ssl: { rejectUnauthorized: false },
});

// Test DB connection
pool.connect()
    .then(() => console.log("PostgreSQL connected"))
    .catch((err) => console.error("DB connection error:", err));

// Simple route
app.get("/", (req, res) => {
    res.send("Server is running!");
});

// Test DB route
app.get("/test-db", async (req, res) => {
    try {
        const result = await pool.query("SELECT NOW()");
        res.json(result.rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));

require("dotenv").config();

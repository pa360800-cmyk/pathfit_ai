import { createServer } from "vite";

try {
    const server = await createServer({
        configFile: "./vite.config.js",
        server: { port: 5173, host: true },
    });

    await server.listen();
    server.printUrls();
} catch (err) {
    console.error("Failed to start server:", err);
    process.exit(1);
}

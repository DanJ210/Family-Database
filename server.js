import express from 'express';
import initSqlJs from 'sql.js';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const port = 3000;

// Middleware
app.use(express.json());
app.use(express.static('.'));

// Database variables
let SQL;
let db;
const dbPath = path.join(__dirname, 'focarino_member.sqlite3');

async function initializeDatabase() {
    try {
        // Initialize sql.js
        SQL = await initSqlJs();
        
        // Try to load existing database or create new one
        let data;
        if (fs.existsSync(dbPath)) {
            data = fs.readFileSync(dbPath);
        }
        
        db = new SQL.Database(data);
        
        // Create table if it doesn't exist
        const createTable = `
            CREATE TABLE IF NOT EXISTS family_members (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                firstname TEXT NOT NULL,
                lastname TEXT NOT NULL,
                birthdate TEXT,
                city TEXT NOT NULL,
                state TEXT NOT NULL,
                joindate TEXT NOT NULL
            )
        `;
        
        db.run(createTable);
        
        // Save database to file
        const dbData = db.export();
        fs.writeFileSync(dbPath, dbData);
        
        console.log('Database initialized successfully');
        return true;
    } catch (error) {
        console.error('Error initializing database:', error);
        return false;
    }
}

function saveDatabase() {
    try {
        const data = db.export();
        fs.writeFileSync(dbPath, data);
    } catch (error) {
        console.error('Error saving database:', error);
    }
}

// API Routes

// Initialize database
app.post('/api/init', async (req, res) => {
    try {
        const success = await initializeDatabase();
        res.json({ success });
    } catch (error) {
        console.error('Init error:', error);
        res.json({ success: false, error: error.message });
    }
});

// Get all members
app.get('/api/members', (req, res) => {
    try {
        if (!db) {
            return res.json({ success: false, error: 'Database not initialized' });
        }
        
        const stmt = db.prepare('SELECT * FROM family_members ORDER BY joindate DESC');
        const members = [];
        
        while (stmt.step()) {
            const row = stmt.getAsObject();
            members.push(row);
        }
        
        stmt.free();
        res.json({ success: true, members });
    } catch (error) {
        console.error('Error fetching members:', error);
        res.json({ success: false, error: error.message });
    }
});

// Get member by ID
app.get('/api/members/:id', (req, res) => {
    try {
        if (!db) {
            return res.json({ success: false, error: 'Database not initialized' });
        }
        
        const stmt = db.prepare('SELECT * FROM family_members WHERE id = ?');
        stmt.bind([req.params.id]);
        
        let member = null;
        if (stmt.step()) {
            member = stmt.getAsObject();
        }
        
        stmt.free();
        
        if (member) {
            res.json({ success: true, member });
        } else {
            res.json({ success: false, error: 'Member not found' });
        }
    } catch (error) {
        console.error('Error fetching member:', error);
        res.json({ success: false, error: error.message });
    }
});

// Add new member
app.post('/api/members', (req, res) => {
    try {
        if (!db) {
            return res.json({ success: false, error: 'Database not initialized' });
        }
        
        const { firstName, lastName, birthDate, city, state } = req.body;
        
        // Validate required fields
        if (!firstName || !lastName || !city || !state) {
            return res.json({ success: false, error: 'Missing required fields' });
        }
        
        const joinDate = new Date().toISOString();
        
        const stmt = db.prepare(`
            INSERT INTO family_members (firstname, lastname, birthdate, city, state, joindate)
            VALUES (?, ?, ?, ?, ?, ?)
        `);
        
        stmt.run([firstName, lastName, birthDate, city, state, joinDate]);
        stmt.free();
        
        saveDatabase();
        
        res.json({ 
            success: true, 
            message: 'Member added successfully' 
        });
    } catch (error) {
        console.error('Error adding member:', error);
        res.json({ success: false, error: error.message });
    }
});

// Update member
app.put('/api/members/:id', (req, res) => {
    try {
        if (!db) {
            return res.json({ success: false, error: 'Database not initialized' });
        }
        
        const { firstName, lastName, birthDate, city, state } = req.body;
        const id = req.params.id;
        
        // Validate required fields
        if (!firstName || !lastName || !city || !state) {
            return res.json({ success: false, error: 'Missing required fields' });
        }
        
        const stmt = db.prepare(`
            UPDATE family_members 
            SET firstname = ?, lastname = ?, birthdate = ?, city = ?, state = ?
            WHERE id = ?
        `);
        
        stmt.run([firstName, lastName, birthDate, city, state, id]);
        const changes = db.getRowsModified();
        stmt.free();
        
        if (changes > 0) {
            saveDatabase();
            res.json({ success: true, message: 'Member updated successfully' });
        } else {
            res.json({ success: false, error: 'Member not found' });
        }
    } catch (error) {
        console.error('Error updating member:', error);
        res.json({ success: false, error: error.message });
    }
});

// Delete member (optional - not in original but useful)
app.delete('/api/members/:id', (req, res) => {
    try {
        if (!db) {
            return res.json({ success: false, error: 'Database not initialized' });
        }
        
        const stmt = db.prepare('DELETE FROM family_members WHERE id = ?');
        stmt.run([req.params.id]);
        const changes = db.getRowsModified();
        stmt.free();
        
        if (changes > 0) {
            saveDatabase();
            res.json({ success: true, message: 'Member deleted successfully' });
        } else {
            res.json({ success: false, error: 'Member not found' });
        }
    } catch (error) {
        console.error('Error deleting member:', error);
        res.json({ success: false, error: error.message });
    }
});

// Serve the main page
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

// Error handling middleware
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ success: false, error: 'Something went wrong!' });
});

// Start server
app.listen(port, async () => {
    console.log(`Focarino Family Guestbook running at http://localhost:${port}`);
    await initializeDatabase();
});

// Graceful shutdown
process.on('SIGINT', () => {
    process.exit(0);
});
import express from 'express';
import Database from 'better-sqlite3';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const port = 3000;

// Middleware
app.use(express.json());
app.use(express.static('.'));

// Initialize SQLite database
let db;

function initializeDatabase() {
    try {
        db = new Database('focarino_member.sqlite3');
        
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
        
        db.exec(createTable);
        console.log('Database initialized successfully');
        return true;
    } catch (error) {
        console.error('Error initializing database:', error);
        return false;
    }
}

// API Routes

// Initialize database
app.post('/api/init', (req, res) => {
    const success = initializeDatabase();
    res.json({ success });
});

// Get all members
app.get('/api/members', (req, res) => {
    try {
        const stmt = db.prepare('SELECT * FROM family_members ORDER BY joindate DESC');
        const members = stmt.all();
        res.json({ success: true, members });
    } catch (error) {
        console.error('Error fetching members:', error);
        res.json({ success: false, error: error.message });
    }
});

// Get member by ID
app.get('/api/members/:id', (req, res) => {
    try {
        const stmt = db.prepare('SELECT * FROM family_members WHERE id = ?');
        const member = stmt.get(req.params.id);
        
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
        
        const result = stmt.run(firstName, lastName, birthDate, city, state, joinDate);
        
        res.json({ 
            success: true, 
            id: result.lastInsertRowid,
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
        
        const result = stmt.run(firstName, lastName, birthDate, city, state, id);
        
        if (result.changes > 0) {
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
        const stmt = db.prepare('DELETE FROM family_members WHERE id = ?');
        const result = stmt.run(req.params.id);
        
        if (result.changes > 0) {
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
app.listen(port, () => {
    console.log(`Focarino Family Guestbook running at http://localhost:${port}`);
    initializeDatabase();
});

// Graceful shutdown
process.on('SIGINT', () => {
    if (db) {
        db.close();
    }
    process.exit(0);
});
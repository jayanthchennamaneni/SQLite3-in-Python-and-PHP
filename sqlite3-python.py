import sqlite3

# 1. creating a connection to database
conn = sqlite3.connect('chelsea-py.db')

# 2. creating a table with UNIQUE constraint on 'name'
cursor = conn.cursor()
cursor.execute("""
                CREATE TABLE IF NOT EXISTS players (
                    id INTEGER PRIMARY KEY, 
                    name TEXT UNIQUE, 
                    position TEXT
                )
                """)

# 3. Inserting or replacing a single player (Upsert)
cursor.execute("INSERT OR IGNORE INTO players (name, position) VALUES (?,?)", ('Eden Hazard', 'Attack midfielder'))

# 4. Inserting multiple players (Upsert for each)
players1 = [('kante', 'defence midfielder'), ('Drogba', 'striker')]
cursor.executemany("INSERT OR IGNORE INTO players (name, position) VALUES (?, ?)", players1)

# 5. Updating a player explicitly (this is not needed if you're using INSERT OR REPLACE)
cursor.execute("UPDATE players SET position = ? WHERE name = ?", ('winger', 'Eden Hazard'))

# 7. Deleting data (this will still work the same)
cursor.execute("DELETE FROM players WHERE name = ?", ('sterling',))

# 8. Querying the database
name = 'Drogba'
cursor.execute("SELECT position FROM players WHERE name = ?", (name,))


# 9. Transactions
try:
    cursor.execute("INSERT OR IGNORE INTO players (name, position) VALUES (?,?)", ('Lampard', 'Attack midfielder'))
    cursor.execute("UPDATE players SET position = ? WHERE name = ?", ('bosses', 'Eden Hazard'))
    conn.commit()

except Exception as e:
    conn.rollback()
    print(f"Transaction failed: {e}")

# 10. Fetch and print all players
cursor.execute("SELECT * FROM players")
rows = cursor.fetchall()

for row in rows:
    print(row)

# Closing the connection
conn.close()
#!/usr/bin/python
from skpy import Skype
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="root",
  database="reminders"
)

mycursor = mydb.cursor(dictionary=True)
mycursor.execute('SELECT * FROM reminders where date(remind_at) = date(now()) and DATE_FORMAT(remind_at, "%H:%i") <= DATE_FORMAT(now(), "%H:%i") and active = 1 limit 1')
# mycursor.execute('SELECT * FROM reminders where date(remind_at) <= date(now()) and active = 1 limit 1')
reminder = mycursor.fetchone()
if reminder != None:
  reminderId = reminder['id']
  reminderTitle = reminder['title']
  reminderDesc = reminder['description']
  message = reminderTitle + ' : ' + reminderDesc
  sql = "SELECT name, skype FROM reminder_users left join users on reminder_users.user_id = users.id where reminder_id = %s"
  params = (reminderId,)
  mycursor.execute(sql, params)
  users = mycursor.fetchall()
  if len(users) > 0:
    username = 'username'
    password = 'password'
    sk = Skype(username, password, 'session.txt') # connect to Skype
    for user in users:
      skype = user['skype']
      if skype != '':
        ch = sk.contacts[skype].chat
        foo = ch.sendMsg(message)
        sql = "update reminders set active = 0 where id = %s"
        params = (reminderId,)
        mycursor.execute(sql, params)
        mydb.commit()
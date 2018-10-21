<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reminders</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
  <link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css">
</head>
<body>
  <div class="container" id="app">
    <form class="form-inline">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="form.title" required="true">
      </div>
      <div class="form-group">
        <input type="text"class="form-control" placeholder="Description" v-model="form.desc" required="true">
      </div>
      <div class="form-group">
        <label for="date">Participants:</label>
        <select class="form-control" v-model="form.participants" multiple>
          <option :value="user.id" v-for="(user, index) in users">{{ user.name }}</option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" class="form-control" v-model="form.date">
      </div>
      <div class="form-group">
        <label for="time">Time:</label>
        <input type="time" id="time" class="form-control" v-model="form.time">
      </div>
      <button @click.prevent="save" class="btn btn-default">Save</button>
    </form>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Desc</th>
          <th>Remind At</th>
          <th>Created At</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(reminder, index) in reminders">
          <td>{{ reminder.title }}</td>
          <td>{{ reminder.description }}</td>
          <td>{{ reminder.remind_at }}</td>
          <td>{{ reminder.created_at }}</td>
          <td>{{ (reminder.active == 0) ? 'Done' : 'Scheduled'}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <script>
    var app = new Vue({
      el: '#app',
      data() {
        return {
          reminders:[],
          users: [],
          form: {
            title: '',
            desc: '',
            participants: [],
            date: '',
            time: '',
            action: 'get',
          }
        }
      },
      mounted() {
        this.getUsers();
      },
      methods: {
        getReminders() {
          this.form.action = 'get';
          var vm = this;
          axios.get('server.php', {params: this.form}).then(function(response){
            vm.reminders = response.data;
            console.log(response);
          }).catch(function(err){
            console.log(err);
          });
        },
        getUsers() {
          this.form.action = 'get_users';
          var vm = this;
          axios.get('server.php', {params: this.form}).then(function(response){
            vm.users = response.data;
            vm.getReminders();
          }).catch(function(err){
            console.log(err);
          });
        },
        save() {
          var vm = this;
          this.form.action = 'save';
          axios.get('server.php', {params: this.form}).then(function(response){
            var reminder = response.data;
            vm.reminders.unshift(reminder);
            vm.form.title = '';
            vm.form.desc = '';
            vm.form.participants = [];
            vm.form.date = '';
            vm.form.time = '';
          }).catch(function(err){
            console.log(err);
          });
        }
      }
    })
  </script>
</body>
</html>
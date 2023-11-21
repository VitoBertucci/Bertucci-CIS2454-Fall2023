package BitBuzz;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;

public class UserModel {

    public static ArrayList<User> getUsers() {

        ArrayList<User> users = new ArrayList<>();

        try {
            Connection connection = DBConnection.getConnection();

            Statement statement = connection.createStatement();

            ResultSet results = statement.executeQuery("select * from user");

            while (results.next()) {
                int id = results.getInt("id");
                String username = results.getString("username");
                String password = results.getString("password");
                String emailAddress = results.getString("email_address");

                User user = new User(id, username, password, emailAddress);
                users.add(user);

            }

            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            System.out.println(e);
        }

        return users;
    }

    public static void addUser(User user) {

        try {

            Connection connection = DBConnection.getConnection();

            String query = "insert into user (username, password, email_address) values (?, ?, ?)";
            PreparedStatement statement = connection.prepareStatement(query);

            statement.setString(1, user.getUsername());
            statement.setString(2, user.getPassword());
            statement.setString(3, user.getEmailAddress());

            statement.execute();

            statement.close();
            connection.close();
        } catch (Exception e) {
            System.out.println(e);
        }
    }

    public static boolean login(String username, String password) {
        try {
            Connection connection = DBConnection.getConnection();

            String query = "SELECT * FROM user WHERE username = ?";
            PreparedStatement statement = connection.prepareStatement(query);

            statement.setString(1, username);

            ResultSet results = statement.executeQuery();

            if (results.next()) {
                String storedPassword = results.getString("password");

                results.close();
                statement.close();
                connection.close();

                return storedPassword.equals(Tools.toHashString(password));
            }

            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            System.out.println(e);
        }

        return false;
    }

    public static User findUserByUsername(String username) {
        User user = null;

        try {
            Connection connection = DBConnection.getConnection();

            String query = "SELECT * FROM user WHERE username = ?";
            PreparedStatement statement = connection.prepareStatement(query);

            statement.setString(1, username);

            ResultSet results = statement.executeQuery();

            if (results.next()) {
                int id = results.getInt("id");
                String foundUsername = results.getString("username");
                String password = results.getString("password");
                String emailAddress = results.getString("email_address");

                user = new User(id, foundUsername, password, emailAddress);
            }

            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            System.out.println(e);
        }

        return user;
    }

}

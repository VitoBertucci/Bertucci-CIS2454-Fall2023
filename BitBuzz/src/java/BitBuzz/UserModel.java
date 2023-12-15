package BitBuzz;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class UserModel {

    //central method to establish a database connection
    private static Connection getConnection() throws Exception {
        return DBConnection.getConnection();
    }

    //private method to handle ResultSet processing
    private static User createUserFromResultSet(ResultSet resultSet) throws Exception {
        //get attribute values
        int id = resultSet.getInt("id");
        String username = resultSet.getString("username");
        String password = resultSet.getString("password");
        String emailAddress = resultSet.getString("email_address");

        //return new user from attributes
        return new User(id, username, password, emailAddress);
    }

    //get a list of users from the database
    public static ArrayList<User> getUsers() {
        //create user list and query
        ArrayList<User> users = new ArrayList<>();
        String query = "SELECT * FROM user";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query);  ResultSet results = statement.executeQuery()) {

            //add user to list
            while (results.next()) {
                users.add(createUserFromResultSet(results));
            }
        } catch (Exception e) {
            System.out.println(e);
        }
        return users;
    }

    //get following users of a given user
    public static ArrayList<User> getFollowing(User user) {
        //create user list and query
        ArrayList<User> following = new ArrayList<>();
        String query = "SELECT u.* FROM user u INNER JOIN followers f ON u.id = f.following_id WHERE f.follower_id = ?";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setInt(1, user.getId());
            try ( ResultSet results = statement.executeQuery()) {

                //add user to list
                while (results.next()) {
                    following.add(createUserFromResultSet(results));
                }
            }
        } catch (Exception e) {
            System.out.println(e);
        }
        return following;
    }

    //get followers of a given user
    public static ArrayList<User> getFollowers(User user) {
        //create user list and query
        ArrayList<User> followers = new ArrayList<>();
        String query = "SELECT u.* FROM user u INNER JOIN followers f ON u.id = f.follower_id WHERE f.following_id = ?";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setInt(1, user.getId());
            try ( ResultSet results = statement.executeQuery()) {

                //add user to list
                while (results.next()) {
                    followers.add(createUserFromResultSet(results));
                }
            }
        } catch (Exception e) {
            System.out.println(e);
        }
        return followers;
    }

    //get a list of users not followed by a given user
    public static ArrayList<User> getUsersNotFollowed(User currentUser) {
        //create user list and query
        ArrayList<User> usersNotFollowed = new ArrayList<>();
        String query = "SELECT * FROM user WHERE id NOT IN (SELECT following_id FROM followers WHERE follower_id = ?) AND id <> ?";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setInt(1, currentUser.getId());
            statement.setInt(2, currentUser.getId());
            try ( ResultSet results = statement.executeQuery()) {
                //add user to list
                while (results.next()) {
                    usersNotFollowed.add(createUserFromResultSet(results));
                }
            }
        } catch (Exception e) {
            System.out.println(e);
        }
        return usersNotFollowed;
    }

    //add a user to the database
    public static boolean addUser(User user) {

        try {
            Connection connection = DBConnection.getConnection();

            //check if username already exists
            String checkUserQuery = "SELECT id FROM user WHERE username = ?";
            PreparedStatement statement = connection.prepareStatement(checkUserQuery);
            statement.setString(1, user.getUsername());
            ResultSet resultSet = statement.executeQuery();
            if (resultSet.next()) {
                return false;
            }

            //check if email already exists
            String checkEmailQuery = "SELECT id FROM user WHERE email_address = ?";
            statement = connection.prepareStatement(checkEmailQuery);
            statement.setString(1, user.getEmailAddress());
            resultSet = statement.executeQuery();
            if (resultSet.next()) {
                return false;
            }

            //insert new user
            String query = "INSERT INTO user (username, password, email_address) VALUES (?, ?, ?)";
            statement = connection.prepareStatement(query);
            statement.setString(1, user.getUsername());
            statement.setString(2, user.getPassword());
            statement.setString(3, user.getEmailAddress());
            statement.execute();

            return true;

        } catch (Exception e) {
            System.out.println(e);
            return false;
        }
    }

    //find a user by username
    public static User findUserByUsername(String username) {
        //set query
        String query = "SELECT * FROM user WHERE username = ?";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setString(1, username);
            try ( ResultSet results = statement.executeQuery()) {
                if (results.next()) {

                    //return found user
                    return createUserFromResultSet(results);
                }
            }
        } catch (Exception e) {
            System.out.println(e);
        }
        return null;
    }

    //validate login credentials
    public static boolean login(String username, String password) {
        //set query
        String query = "SELECT * FROM user WHERE username = ?";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setString(1, username);
            try ( ResultSet results = statement.executeQuery()) {
                if (results.next()) {
                    String storedPassword = results.getString("password");

                    //return if valid login details
                    return storedPassword.equals(Tools.toHashString(password));
                }
            }
        } catch (Exception e) {
            System.out.println(e);
        }
        return false;
    }

    //follow a user
    public static void follow(int targetUserToFollowId, int loggedInUserId) {
        //set query
        String query = "INSERT INTO Followers (follower_id, following_id) VALUES (?, ?)";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setInt(1, loggedInUserId);
            statement.setInt(2, targetUserToFollowId);
            statement.executeUpdate();
        } catch (Exception e) {
            System.out.println(e);
        }
    }

    //unfollow a user
    public static void unfollow(int targetUserToUnfollowId, int loggedInUserId) {
        //set query
        String query = "DELETE FROM Followers WHERE follower_id = ? AND following_id = ?";

        //execute query
        try ( Connection connection = getConnection();  PreparedStatement statement = connection.prepareStatement(query)) {
            statement.setInt(1, loggedInUserId);
            statement.setInt(2, targetUserToUnfollowId);
            statement.executeUpdate();
        } catch (Exception e) {
            System.out.println(e);
        }
    }
}

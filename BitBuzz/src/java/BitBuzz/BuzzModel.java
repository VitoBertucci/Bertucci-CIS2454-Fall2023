package BitBuzz;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.ArrayList;

public class BuzzModel {

    //helper method to create a buzz from a result set 
    private static Buzz createBuzzFromResultSet(ResultSet results) throws SQLException {
        int id = results.getInt("id");
        int userId = results.getInt("user_id");
        String text = results.getString("text");
        int likeCount = results.getInt("likes");
        Timestamp originalTimestamp = results.getTimestamp("timestamp");
        String timestamp = formatTimestamp(originalTimestamp);

        return new Buzz(id, userId, text, timestamp, originalTimestamp, likeCount);
    }

    //get all buzzes from db and order by timestamp
    public static ArrayList<Buzz> getBuzzes() {
        //initialize list of buzzes
        ArrayList<Buzz> buzzes = new ArrayList<>();

        try {
            //establish connection
            Connection connection = DBConnection.getConnection();
            Statement statement = connection.createStatement();
            //execute query
            ResultSet results = statement.executeQuery("select * from buzz ORDER BY timestamp DESC");

            //iterate through results and add to list
            while (results.next()) {
                buzzes.add(createBuzzFromResultSet(results));
            }

            //close connections and statements
            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            //print exception
            System.out.println(e);
        }

        //return list of buzzes
        return buzzes;
    }

    //get buzzes by a specific user
    public static ArrayList<Buzz> getBuzzesByUser(User user) {
        //convert user id to string
        String userId = String.valueOf(user.getId());

        //initialize list of buzzes
        ArrayList<Buzz> buzzes = new ArrayList<>();

        try {
            //establish connection
            Connection connection = DBConnection.getConnection();
            //prepare statement with query
            String query = "SELECT * FROM buzz WHERE user_id = ? ORDER BY timestamp DESC";
            PreparedStatement statement = connection.prepareStatement(query);
            //set user id
            statement.setString(1, userId);
            //execute query
            ResultSet results = statement.executeQuery();

            //iterate through results and add to list
            while (results.next()) {
                buzzes.add(createBuzzFromResultSet(results));
            }

            //close connections and statements
            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            //print exception
            System.out.println(e);
        }

        //return list of buzzes
        return buzzes;
    }

    //get a single buzz by its id
    public static Buzz getBuzzById(int buzzId) {
        Buzz buzz = null;

        try {
            //establish connection
            Connection connection = DBConnection.getConnection();
            //prepare statement with query
            String query = "SELECT * FROM buzz WHERE id = ?";
            PreparedStatement statement = connection.prepareStatement(query);
            //set buzz id
            statement.setInt(1, buzzId);
            //execute query
            ResultSet results = statement.executeQuery();

            //if buzz is found, initialize it
            while (results.next()) {
                buzz = createBuzzFromResultSet(results);
            }

            //close connections and statements
            results.close();
            statement.close();
            connection.close();
        } catch (Exception e) {
            //print exception
            System.out.println(e);
        }

        //return the found buzz
        return buzz;
    }

    //get buzzes by a list of users
    public static ArrayList<Buzz> getBuzzesByListofUsers(ArrayList<User> userList) {
        //initialize list of buzzes
        ArrayList<Buzz> buzzes = new ArrayList<>();
        try {
            //establish connection
            Connection connection = DBConnection.getConnection();

            //manually constructing the list of user ids
            StringBuilder userIDs = new StringBuilder();
            for (int i = 0; i < userList.size(); i++) {
                userIDs.append(userList.get(i).getId());
                if (i < userList.size() - 1) {
                    userIDs.append(",");
                }
            }

            //prepare statement with query
            String query = "SELECT b.*, u.username FROM buzz b INNER JOIN user u ON b.user_id = u.id WHERE b.user_id IN (" + userIDs.toString() + ") ORDER BY timestamp DESC";
            Statement statement = connection.createStatement();
            //execute query
            ResultSet results = statement.executeQuery(query);

            //iterate through results and add to list
            while (results.next()) {
                Buzz buzz = createBuzzFromResultSet(results);
                buzz.setAuthorUsername(results.getString("username"));
                buzzes.add(buzz);
            }

            //close connections and statements
            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            //print exception
            System.out.println(e);
        }
        //return list of buzzes
        return buzzes;
    }

    //add a new buzz to the database
    public static void addBuzz(Buzz buzz) {
        try {
            //establish connection
            Connection connection = DBConnection.getConnection();
            //prepare statement with query
            String query = "insert into buzz (text, user_id) values (?, ?)";
            PreparedStatement statement = connection.prepareStatement(query);

            //set parameters for the buzz
            statement.setString(1, buzz.getText());
            statement.setInt(2, buzz.getUserId());

            //execute update
            statement.execute();

            //close statement and connection
            statement.close();
            connection.close();
        } catch (Exception e) {
            //print exception
            System.out.println(e);
        }
    }

    //increase like count for a buzz
    public static void addLike(Buzz buzz) {
        try {
            //establish connection
            Connection connection = DBConnection.getConnection();
            //prepare statement with query
            String query = "UPDATE buzz SET likes = likes + 1 WHERE id = ?";
            PreparedStatement statement = connection.prepareStatement(query);

            //set buzz id
            statement.setInt(1, buzz.getId());

            //execute update
            statement.executeUpdate();
            //close statement and connection
            statement.close();
            connection.close();
        } catch (Exception e) {
            //print exception
            System.out.println(e);
        }
    }

    //format timestamp for displaying
    public static String formatTimestamp(Timestamp timestamp) {
        SimpleDateFormat sdf = new SimpleDateFormat("MM/dd/yyyy h:mm a");
        //format and return timestamp
        return sdf.format(timestamp);
    }
}

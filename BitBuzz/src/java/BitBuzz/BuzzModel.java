package BitBuzz;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;
import java.sql.Timestamp;
import java.util.ArrayList;

public class BuzzModel {

    public static ArrayList<Buzz> getBuzzes() {

        ArrayList<Buzz> buzzes = new ArrayList<>();

        try {
            Connection connection = DBConnection.getConnection();

            Statement statement = connection.createStatement();

            ResultSet results = statement.executeQuery("select * from buzz");

            while (results.next()) {
                int id = results.getInt("id");
                int userId = results.getInt("user_id");
                String text = results.getString("text");
                Timestamp timestamp = results.getTimestamp("timestamp");

                Buzz buzz = new Buzz(id, userId, text);
                buzz.setTimestamp(timestamp);
                buzzes.add(buzz);

            }

            results.close();
            statement.close();
            connection.close();

        } catch (Exception e) {
            System.out.println(e);
        }

        return buzzes;
    }

    public static void addBuzz(Buzz buzz) {

        try {

            Connection connection = DBConnection.getConnection();

            String query = "insert into buzz (text, user_id) values (?, ?)";
            PreparedStatement statement = connection.prepareStatement(query);

            statement.setString(1, buzz.getText());
            statement.setInt(2, buzz.getUserId());

            statement.execute();

            statement.close();
            connection.close();
        } catch (Exception e) {
            System.out.println(e);
        }
    }
}

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package BitBuzz;

import java.sql.Connection;
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
                String firstName = results.getString("first_name");
                String lastName = results.getString("last_name");

                User user = new User(id, username, emailAddress, password, firstName, lastName);

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
}

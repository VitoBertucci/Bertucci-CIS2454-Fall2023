package BitBuzz;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DBConnection {

    public static Connection getConnection() throws SQLException, ClassNotFoundException {
        Class.forName("com.mysql.cj.jdbc.Driver");
        String dbURL = "jdbc:mysql://localhost:3306/BitBuzz";
        

        Connection connection = DriverManager.getConnection(dbURL, "vitob", "Dvorvb01");
        return connection;
    }
}

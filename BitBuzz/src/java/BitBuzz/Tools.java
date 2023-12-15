package BitBuzz;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;

public class Tools {
    
    /*---------      application-wide tools      ----------*/

    //hash a given string
    public static String toHashString(String s) {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-256");
            byte[] hashInBytes = md.digest(s.getBytes());

            StringBuilder sb = new StringBuilder();
            for (byte b : hashInBytes) {
                sb.append(String.format("%02x", b));
            }
            return sb.toString();
        } catch (NoSuchAlgorithmException e) {
            throw new RuntimeException("No such algorithm: SHA-256", e);
        }
    }
    
    //format timestamp for displaying
    public static String formatTimestamp(Timestamp timestamp) {
        SimpleDateFormat sdf = new SimpleDateFormat("MM/dd/yyyy h:mm a");
        //format and return timestamp
        return sdf.format(timestamp);
    }
}


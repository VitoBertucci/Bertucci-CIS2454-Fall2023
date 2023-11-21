package BitBuzz;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class Tools {

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
}


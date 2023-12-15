package BitBuzz;

import java.sql.Timestamp;

public class Buzz {

    private int id, userId, likeCount;
    private String text, timestamp, authorUsername;
    private Timestamp originalTimestamp;

    public Buzz(int id, int userId, String text, String timestamp, Timestamp originalTimestamp, int likeCount) {
        this.id = id;
        this.userId = userId;
        this.text = text;
        this.timestamp = timestamp;
        this.originalTimestamp = originalTimestamp;
        this.likeCount = likeCount;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public String getAuthorUsername() {
        return authorUsername;
    }

    public void setAuthorUsername(String authorUsername) {
        this.authorUsername = authorUsername;
    }

    public Timestamp getOriginalTimestamp() {
        return originalTimestamp;
    }

    public void setOriginalTimestamp(Timestamp originalTimestamp) {
        this.originalTimestamp = originalTimestamp;
    }

    public String getTimestamp() {
        return timestamp;
    }

    public void setTimestamp(String timestamp) {
        this.timestamp = timestamp;
    }

    public int getLikeCount() {
        return likeCount;
    }

    public void setLikeCount(int likeCount) {
        this.likeCount = likeCount;
    }

}

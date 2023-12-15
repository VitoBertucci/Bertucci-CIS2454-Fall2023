package BitBuzz;

import java.util.ArrayList;

public class User {

    private int id;
    private String username, emailAddress, password, firstName, lastName;
    private ArrayList<User> following, followers;
    
    public User(int id, String username, String password, String emailAddress) {
        this.id = id;
        this.username = username;
        this.password = password;
        this.emailAddress = emailAddress;
    }

    public User(int id, String username) {
        this.id = id;
        this.username = username;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getEmailAddress() {
        return emailAddress;
    }

    public void setEmailAddress(String emailAddress) {
        this.emailAddress = emailAddress;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public ArrayList getFollowers() {
        return followers;
    }

    public void addFollower(User u) {
        this.followers.add(u);
    }

    public void removeFollower(User u) {
        this.followers.remove(u);
    }

    public void addFollowing(User u) {
        this.following.add(u);
    }

    public void removeFollowing(User u) {
        this.following.remove(u);
    }

}

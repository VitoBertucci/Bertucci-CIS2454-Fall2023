package BitBuzz;

import java.io.IOException;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

public class BitBuzz extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

        //get action param
        String action = request.getParameter("action");

        //get session
        HttpSession session = request.getSession(false);

        if (action == null || action.isEmpty()) {
            //handle case where action is not provided
            response.sendRedirect("home.jsp");
            return;
        }

        switch (action.toLowerCase()) {
            case "home":
                home(request, response, session);
                break;
            case "like":
                like(request, response);
                break;
            case "reply":
                reply(request, response);
                break;
            case "createbuzz":
                createBuzz(request, response, session);
                break;
            case "createuser":
                createUser(request, response);
                break;
            case "followuser":
                followUser(request, response, session);
                break;
            case "unfollowuser":
                unfollowUser(request, response, session);
                break;
            case "login":
                loginUser(request, response);
                break;
            case "signup":
                signUp(request, response, session);
                break;
            case "logout":
                logoutUser(session, response);
                break;
            case "listdata":
                listData(request, response, session);
                break;
            case "displayprofile":
                displayProfile(request, response);
                break;
            default:
                response.sendRedirect("home.jsp");
        }
    }

    //like a post
    private void like(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        int buzzId = Integer.parseInt(request.getParameter("buzzId"));

        //fetch buzz to be liked
        Buzz selectedBuzz = BuzzModel.getBuzzById(buzzId);

        //redirect to home
        if (selectedBuzz != null) {
            BuzzModel.addLike(selectedBuzz);
            response.sendRedirect("BitBuzz?action=home");
        }
    }

    //reply to a post
    private void reply(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

        //fetch buzz to be replied to
        Buzz selectedBuzz = BuzzModel.getBuzzById(Integer.parseInt(request.getParameter("buzzId")));

        //fetch author username and store user with assoc. usernanme
        String authorUsername = request.getParameter("authorUsername");
        User author = UserModel.findUserByUsername(authorUsername);

        //send the buzz and the author to the buzz page
        if (selectedBuzz != null) {
            request.setAttribute("buzz", selectedBuzz);
            request.setAttribute("author", author);
            request.getRequestDispatcher("/buzz.jsp").forward(request, response);
        }

    }

    //load home page
    private void home(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws ServletException, IOException {
        if (session != null && session.getAttribute("user") != null) {

            //store logged in user and get their following users
            User currentUser = (User) session.getAttribute("user");
            ArrayList<User> following = UserModel.getFollowing(currentUser);
            following.add(currentUser);

            //store buzzes from logged in user's following
            ArrayList<Buzz> followingBuzzes = BuzzModel.getBuzzesByListofUsers(following);

            //send following user's buzzes to home page
            request.setAttribute("followingBuzzes", followingBuzzes);
            getServletContext().getRequestDispatcher("/home.jsp").forward(request, response);
        } else {
            getServletContext().getRequestDispatcher("/login.jsp").forward(request, response);
        }
    }

    //unfollow user
    private void unfollowUser(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws ServletException, IOException {

        //store selected username to unfollow
        int userIdToUnfollow = Integer.parseInt(request.getParameter("userIdToUnfollow"));

        if (session != null && session.getAttribute("user") != null) {

            //store current user
            User currentUser = (User) session.getAttribute("user");

            //if user is found, remove from following
            UserModel.unfollow(userIdToUnfollow, currentUser.getId());

            //redirect to profile
            response.sendRedirect("BitBuzz?action=displayprofile&username=" + currentUser.getUsername());
        }
    }

    //follow user (or users)
    private void followUser(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws ServletException, IOException {

        //store list of usernames given to follow
        int userIdToFollow = Integer.parseInt(request.getParameter("userIdToFollow"));

        if (session != null && session.getAttribute("user") != null) {

            //store current user
            User currentUser = (User) session.getAttribute("user");

            UserModel.follow(userIdToFollow, currentUser.getId());

            //after following, redirect to the profile page.
            response.sendRedirect("BitBuzz?action=displayprofile&username=" + currentUser.getUsername());
        }
    }

    //display give user's profile
    private void displayProfile(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

        //store given username to display profile of and current user
        String username = request.getParameter("username");
        HttpSession session = request.getSession(false);
        User loggedInUser = (User) session.getAttribute("user");

        if (username != null && loggedInUser != null) {

            //find and store user with given username
            User user = UserModel.findUserByUsername(username);

            //if user exists
            if (user != null) {

                //store that user's followers, following, and buzzes
                ArrayList<User> following = UserModel.getFollowing(user);
                ArrayList<User> followers = UserModel.getFollowers(user);
                ArrayList<Buzz> buzzes = BuzzModel.getBuzzesByUser(user);

                //check if the user to display a profile of is the current user
                Boolean isOwnProfile = loggedInUser.getUsername().equals(user.getUsername());

                //check if the current user follows the user to display
                Boolean isFollowing = followers.contains(loggedInUser);

                //send data to profile page to display
                request.setAttribute("user", user);
                request.setAttribute("following", following);
                request.setAttribute("followers", followers);
                request.setAttribute("buzzes", buzzes);
                request.setAttribute("isOwnProfile", isOwnProfile);
                request.setAttribute("isFollowing", isFollowing);
                getServletContext().getRequestDispatcher("/profile.jsp").forward(request, response);
            } else {

                //display generic search error message
                String searchError = "No user with that username.";
                request.setAttribute("searchError", searchError);
                getServletContext().getRequestDispatcher("/profile.jsp").forward(request, response);
            }
        }
    }

    //list all data from users and buzzes
    private void listData(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws ServletException, IOException {
        //get current user 
        User currentUser = (User) session.getAttribute("user");

        //pass not followed users
        request.setAttribute("users", UserModel.getUsersNotFollowed(currentUser));
        request.setAttribute("buzzes", BuzzModel.getBuzzes());
        getServletContext().getRequestDispatcher("/data.jsp").forward(request, response);
    }

    //create new buzz
    private void createBuzz(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws IOException {

        //check if valid sessions and user
        if (session != null && session.getAttribute("user") != null) {

            //store content text, current user and user ID
            String text = request.getParameter("text");
            User user = (User) session.getAttribute("user");
            int userId = user.getId();

            //create new buzz with user info
            Buzz newBuzz = new Buzz(0, userId, text, "", null, 0);
            newBuzz.setAuthorUsername(user.getUsername());
            BuzzModel.addBuzz(newBuzz);

            //redirect to data page
            response.sendRedirect("BitBuzz?action=home");
        }
    }

    //create new user
    private void createUser(HttpServletRequest request, HttpServletResponse response) throws IOException {

        //store given username, password, and email address
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        String emailAddress = request.getParameter("emailAddress");

        //create new user from given data
        User newUser = new User(0, username, Tools.toHashString(password), emailAddress);
        UserModel.addUser(newUser);
        response.sendRedirect("BitBuzz?action=listdata");
    }

    private void signUp(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws ServletException, IOException {

        //store given username, password, and email address
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        String emailAddress = request.getParameter("emailAddress");

        //create new user object
        User newUser = new User(0, username, Tools.toHashString(password), emailAddress);

        //if user data is invalid, display error and do not insert user into db
        if (UserModel.addUser(newUser)) {
            session.setAttribute("user", UserModel.findUserByUsername(username));
            response.sendRedirect("BitBuzz?action=home");
        } else {
            //if user is successfully inserted, login user and direct to home page
            request.setAttribute("signupError", "Username or Email already in use.");
            request.getRequestDispatcher("signup.jsp").forward(request, response);
        }
    }

    //login current user with given credentials
    private void loginUser(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

        //store given username and password
        String username = request.getParameter("username");
        String password = request.getParameter("password");

        //if login function returns true
        if (UserModel.login(username, password)) {

            //set session user to the user associated with the username and password
            HttpSession session = request.getSession();
            session.setAttribute("user", UserModel.findUserByUsername(username));
            response.sendRedirect("BitBuzz?action=home");
        } else {

            //display login error
            request.setAttribute("loginError", "Invalid username or password");
            request.getRequestDispatcher("login.jsp").forward(request, response);
        }
    }

    //logout current user
    private void logoutUser(HttpSession session, HttpServletResponse response) throws IOException {

        //terminate session
        if (session != null) {
            session.invalidate();
        }

        //redirect to login page
        response.sendRedirect("login.jsp");
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    public String getServletInfo() {
        return "Short description";
    }

}

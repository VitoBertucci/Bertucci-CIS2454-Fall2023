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
        
        String action = request.getParameter("action");
        HttpSession session = request.getSession(false);
        
        switch (action.toLowerCase()) {
            case "home":
                getServletContext().getRequestDispatcher("/home.jsp").forward(request, response);
                break;
            case "listbuzzes":
                listBuzzes(request, response);
                break;
            case "createbuzz":
                createBuzz(request, response, session);
                break;
            case "listusers":
                listUsers(request, response);
                break;
            case "createuser":
                createUser(request, response);
                break;
            case "login":
                loginUser(request, response);
                break;
            case "logout":
                logoutUser(session, response);
                break;
            case "listdata":
                listData(request, response);
                break;
            default:
                response.sendRedirect("home.jsp");
        }
    }
    
    private void listData(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        ArrayList<User> users = UserModel.getUsers();
        ArrayList<Buzz> buzzes = BuzzModel.getBuzzes();

        request.setAttribute("users", users);
        request.setAttribute("buzzes", buzzes);
        getServletContext().getRequestDispatcher("/data.jsp").forward(request, response);
    }
    
    private void listBuzzes(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        ArrayList<Buzz> buzzes = BuzzModel.getBuzzes();
        request.setAttribute("buzzes", buzzes);
        getServletContext().getRequestDispatcher("/buzzes.jsp").forward(request, response);
    }

    private void createBuzz(HttpServletRequest request, HttpServletResponse response, HttpSession session) throws IOException {
        if (session != null && session.getAttribute("user") != null) {
            String text = request.getParameter("text");
            User user = (User) session.getAttribute("user");
            int userId = user.getId();

            Buzz newBuzz = new Buzz(0, userId, text);
            BuzzModel.addBuzz(newBuzz);

            response.sendRedirect("BitBuzz?action=listdata");
        } else {
            response.sendRedirect("login.jsp");
        }
    }

    private void listUsers(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        ArrayList<User> users = UserModel.getUsers();
        request.setAttribute("users", users);
        getServletContext().getRequestDispatcher("/users.jsp").forward(request, response);
    }

    private void createUser(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        String emailAddress = request.getParameter("emailAddress");

        User newUser = new User(0, username, Tools.toHashString(password), emailAddress);
        UserModel.addUser(newUser);
        response.sendRedirect("BitBuzz?action=listdata");
    }

    private void loginUser(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String username = request.getParameter("username");
        String password = request.getParameter("password");

        if (UserModel.login(username, password)) {
            HttpSession session = request.getSession();
            session.setAttribute("user", UserModel.findUserByUsername(username));
            response.sendRedirect("BitBuzz?action=home");
        } else {
            request.setAttribute("loginError", "Invalid username or password");
            request.getRequestDispatcher("login.jsp").forward(request, response);
        }
    }

    private void logoutUser(HttpSession session, HttpServletResponse response) throws IOException {
        if (session != null) {
            session.invalidate();
        }
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

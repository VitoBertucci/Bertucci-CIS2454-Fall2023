package stocks;

import java.util.ArrayList;
import java.util.List;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class stocks extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        List<Stock> stocks = new ArrayList<>();
        stocks.add(new Stock("GME", "Gamestop Corp.", 230.67));
        stocks.add(new Stock("BBB", "Bed, Bath and Beyond Inc.", 12.08));
        stocks.add(new Stock("AMC", "AMC Entertainment Holdings Inc.", 14.89));
        stocks.add(new Stock("TGT", "Target Inc.", 14.61));
        stocks.add(new Stock("EXC", "Exelon Corp.", 39.49));
        stocks.add(new Stock("FDX", "Fedex Corp", 251.08));
        stocks.add(new Stock("PEP", "PepsiCo Inc.", 157.57));

        request.setAttribute("stocks", stocks);

        
        String url = "/stocks.jsp";
        getServletContext().getRequestDispatcher(url).forward(request, response);
        
        }


// <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
/**
 * Handles the HTTP <code>GET</code> method.
 *
 * @param request servlet request
 * @param response servlet response
 * @throws ServletException if a servlet-specific error occurs
 * @throws IOException if an I/O error occurs
 */
@Override
protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}

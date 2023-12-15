<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="BitBuzz.User, BitBuzz.Buzz" %>
<%@page import="java.util.ArrayList" %>
<c:import url="header.jsp" />

<% if (request.getAttribute("searchError") != null) {%>
        <p><%= request.getAttribute("searchError")%></p>
<% } else { %>
    <div class="page-title">
        <h1>${user.username}'s Profile</h1>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>Text</th>
                <th>Timestamp</th>
                <th>Likes</th>
            </tr>
            <c:forEach items="${buzzes}" var="buzz">
                <tr>        
                    <td>${buzz.text}</td>
                    <td>${buzz.timestamp}</td>
                    <td>${buzz.likeCount}</td>
                </tr>
            </c:forEach>
        </table>

        <table>        
            <tr>
                <th>Following</th>
                <% if ((Boolean)request.getAttribute("isOwnProfile")) { %>  
                    <th>Unfollow</th>
                <% } %>
            </tr>
            <c:forEach items="${following}" var="user">
                <tr>        
                    <td>
                        <a href="BitBuzz?action=displayProfile&username=${user.username}">${user.username}</a>
                    </td>
                    <% if ((Boolean)request.getAttribute("isOwnProfile")) { %>  
                    <td>
                        <div class='follow-form'>
                            <form action='BitBuzz' method='post'>
                                <input type='hidden' name='action' value='unfollowUser' />
                                <input type='hidden' name='userIdToUnfollow' value='${user.id}' />
                                <input type='submit' value='Unfollow'/>
                            </form>
                        </div>
                    </td>
                    <% } %>
                </tr>
            </c:forEach>
        </table>

        <table>        
            <tr>
                <th>Followers</th>
            </tr>
            <c:forEach items="${followers}" var="user">
                <tr>        
                    <td>
                        <a href="BitBuzz?action=displayProfile&username=${user.username}">${user.username}</a>
                    </td>
                </tr>
            </c:forEach>
        </table>
    </div>
                
    <!-- Show follow and unfollow button here -->
    
<% } %>


    


<c:import url="footer.jsp" />

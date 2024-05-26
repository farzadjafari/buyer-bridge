describe('Login Page UI Test', () => {
    beforeEach(() => {
        cy.visit('/login');
    });

    it('should display login form with email and password fields', () => {
        cy.contains('Login');
        cy.get('#email').should('exist');
        cy.get('#password').should('exist');
        cy.get('button[type="submit"]').should('exist').contains('Login');
    });

    it('should redirect to messages page after successful login', () => {
        cy.intercept('POST', '/api/login', {
            statusCode: 200,
            body: {
                token: 'token'
            }
        }).as('loginRequest');

        cy.get('#email').type('jon@example.com');
        cy.get('#password').type('password');
        cy.get('form').submit();

        cy.wait('@loginRequest');
        cy.url().should('include', '/messages');
    });
});

describe('Register Page UI Test', () => {
    beforeEach(() => {
        cy.visit('/register');
    });

    it('should display register form with name, email, password', () => {
        cy.contains('Register');
        cy.get('#name').should('exist');
        cy.get('#email').should('exist');
        cy.get('#password').should('exist');
        cy.get('#password_confirmation').should('exist');
    });

    it('should redirect to messages page after successful register', () => {
        cy.intercept('POST', '/api/register', {
            statusCode: 200,
            body: {
                token: 'token'
            }
        }).as('registerRequest')

        cy.get('#name').type('jon');
        cy.get('#email').type('jon@example.com');
        cy.get('#password').type('password');
        cy.get('#password_confirmation').type('password');
        cy.get('form').submit();

        cy.wait('@registerRequest');
        cy.url().should('include', '/messages');

    });
});

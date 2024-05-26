describe('MessageForm Component UI Test', () => {
    beforeEach(() => {
        cy.visit('/login');

        cy.intercept('POST', '/api/login', {
            statusCode: 200,
            body: {
                token: 'token'
            }
        }).as('loginRequest');

        cy.get('#email').type('jon@example.com');
        cy.get('#password').type('password');
        cy.get('button[type="submit"]').click();

        cy.wait('@loginRequest');

        cy.visit('/messages');
    });

    it('should display the message form with required fields', () => {
        cy.get('form').should('exist');
        cy.get('input[type="text"][name="title"]').should('exist');
        cy.get('textarea[name="body"]').should('exist');
        cy.get('input[type="date"][name="scheduled_opening_time"]').should('exist');
        cy.get('button[type="submit"]').should('exist').contains('Submit');
    });

    it('should submit the form with valid data', () => {
        cy.intercept('POST', '/api/messages', {
            statusCode: 200,
            body: {
                data: {
                    id: 1,
                    title: 'Test Message',
                    body: 'This is a test message',
                    scheduled_opening_time: '2024-05-27',
                }
            }
        }).as('submitMessage');

        cy.get('input[type="text"][name="title"]').type('Test Message');
        cy.get('textarea[name="body"]').type('This is a test message');
        cy.get('input[type="date"][name="scheduled_opening_time"]').type('2024-05-27');
        cy.get('form').submit();

        cy.wait('@submitMessage');

        cy.get('input[type="text"][name="title"]').should('have.value', '');
        cy.get('textarea[name="body"]').should('have.value', '');
        cy.get('input[type="date"][name="scheduled_opening_time"]').should('have.value', '');
    });

    it('should display error messages when invalid data is submitted', () => {
        cy.intercept('POST', '/api/messages', {
            statusCode: 422,
            body: {
                errors: {
                    title: ['The title field is required.'],
                    body: ['The body field is required.'],
                    scheduled_opening_time: ['The scheduled opening time field is required.']
                }
            }
        }).as('submitMessage');

        cy.get('form').submit();

        cy.contains('The title field is required.').should('exist');
        cy.contains('The body field is required.').should('exist');
        cy.contains('The scheduled opening time field is required.').should('exist');
    });
});

const assert = require('assert');
const sinon = require('sinon');
const http = require('http');
const PassThrough = require('stream').PassThrough;

const turl = require('./index.js');

describe('turl', () => {
  beforeEach(() => {
    this.request = sinon.stub(http, 'request');
  });

  afterEach(() => {
    this.request.restore();
  });


  it('should return the response when the request is successful', (done) => {
    const expected = 'https://tinyurl/ok';

    const response = new PassThrough();
    response.statusCode = 200;
    response.write(expected);
    response.end();

    const request = new PassThrough();
    this.request.callsArgWith(1, response).returns(request);

    turl.shorten('www.google.com').then((result) => {
      assert(result);
      assert(typeof result === 'string');
      assert.equal(result, expected);
      done();
    }).catch(done);
  });

  it('should return an HTTPS short URL', (done) => {
    const rawResult = 'http://tinyurl/ok';
    const expected = 'https://tinyurl/ok';

    const response = new PassThrough();
    response.statusCode = 200;
    response.write(rawResult);
    response.end();

    const request = new PassThrough();
    this.request.callsArgWith(1, response).returns(request);

    turl.shorten('www.google.com').then((result) => {
      assert(result);
      assert(typeof result === 'string');
      assert.equal(result, expected);
      done();
    }).catch(done);
  });

  it('should return an error when the status code is invalid', (done) => {
    const response = new PassThrough();
    response.statusCode = 400;
    response.end();

    const request = new PassThrough();
    this.request.callsArgWith(1, response).returns(request);

    turl.shorten('www.google.com').catch((error) => {
      assert(error);
      done();
    });
  });

  it('should return in case request fails', (done) => {
    const expected = 'some error';

    const request = new PassThrough();
    this.request.returns(request);

    turl.shorten('www.google.com').catch((error) => {
      assert(error);
      assert.equal(error, expected);
      done();
    });

    request.emit('error', expected);
  });
});
